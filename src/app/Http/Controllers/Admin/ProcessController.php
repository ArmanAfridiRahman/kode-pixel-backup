<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProcessRequest;
use App\Http\Services\FileService;
use App\Models\Admin\Process;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Http\Services\ProcessService;
use Illuminate\Validation\Rule;

class ProcessController extends Controller
{
    private $fileService, $processService;

    public function __construct(){
        $this->fileService = new FileService();
        $this->processService = new ProcessService();
        $this->middleware(['permissions:view_process'])->only('index');
        $this->middleware(['permissions:create_process'])->only('create');
        $this->middleware(['permissions:update_process'])->only('edit', 'update');
        $this->middleware(['permissions:delete_process'])->only('destroy');
    }

    public function index(Request $request) :View{
        return view('admin.process.index', [
            'title' => 'Process List',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Process' => 'admin.process.list'],
            'processs' => Process::with(['createdBy', 'updatedBy'])->filter($request)->latest()->get()                                       
        ]);
    }

    public function create() :View{
        return view('admin.process.create', [
            'title' => 'Process',
            'breadcrumbs' =>  ['Dashboard' => 'admin.home', 'Process' => 'admin.process.list', 'Create' => null],
        ]);
    }

    public function edit(int | string $uid) :View{
        return view('admin.process.edit', [
            'title' => 'Process',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Process' => 'admin.process.list'],
            'process' => Process::where('uid', $uid)->first(),
        ]);
    }

    public function store(ProcessRequest $request) :RedirectResponse{
        $process = $this->processService->save($request);
        return redirect()->route('admin.process.list')->with(response_status('Updated Successfully'));
    }


    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:processs,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);
        Process::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfuly');
        return json_encode($response);
    }

    public function update(ProcessRequest $request) :RedirectResponse{
        $process = $this->processService->update($request);
        return redirect()->route('admin.process.list')->with(response_status('Updated Successfully'));
    }

    public function destroy($uid) :RedirectResponse{

        $response = response_status('Process Not Found', 'error');
        $process = Process::where('uid', $uid)->firstOrFail();

        if($process){
            $response =  response_status('Process Deleted');
            $this->fileService->unlink( config("settings")['file_path']['process_method']['path'],@$process->file->name);
            $process->file()->delete();
            $process->delete();
        }
        return back()->with($response);
    }

     /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request) :RedirectResponse {

        $bulkIds = json_decode($request->input('bulk_id'), true);
        $request->merge([
            "bulk_id" =>  $bulkIds
        ]);
        $rules = [
            'bulk_id' => ['array', 'required'],
            'bulk_id.*' => ['exists:processs,id'],
            'type' => ['required', Rule::in(['status', 'delete'])],
            'value' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('type') === 'status';
                }),

                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'status' && !in_array($value, StatusEnum::toArray())) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];
        $request->validate($rules);
        $response = $this->processService->bulktAction( $request);
        return  back()->with($response);
    }
}
