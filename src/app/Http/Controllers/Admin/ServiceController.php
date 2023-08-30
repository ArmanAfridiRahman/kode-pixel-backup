<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Services\FileService;
use App\Models\Admin\Service;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Http\Services\ServiceService;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    private $fileService, $serviceService;
    public function __construct(){
        $this->fileService = new FileService();
        $this->serviceService = new ServiceService();
        $this->middleware(['permissions:view_service'])->only('index');
        $this->middleware(['permissions:create_service'])->only('create');
        $this->middleware(['permissions:update_service'])->only('edit', 'update');
        $this->middleware(['permissions:delete_service'])->only('destroy');
    }

    public function index(Request $request) :View{
        return view('admin.service.index', [
            'title' => 'Service List',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Service' => 'admin.service.list'],
            'services' => Service::with(['createdBy', 'updatedBy'])->filter($request)->latest()->get()                                       
        ]);
    }

    public function create() :View{
        return view('admin.service.create', [
            'title' => 'Service',
            'breadcrumbs' =>  ['Dashboard' => 'admin.home', 'Service' => 'admin.service.list', 'Create' => null],
        ]);
    }

    public function edit(int | string $uid) :View{
        return view('admin.service.edit', [
            'title' => 'Service',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Service' => 'admin.service.list'],
            'service' => Service::where('uid', $uid)->first(),
        ]);
    }

    public function store(ServiceRequest $request) :RedirectResponse{


        $service = $this->serviceService->save($request);
        return redirect()->route('admin.service.list')->with(response_status('Updated Successfully'));
    }


    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:services,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);
        Service::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfuly');
        return json_encode($response);
    }

    public function update(ServiceRequest $request) :RedirectResponse{
        $service = $this->serviceService->update($request);
        return redirect()->route('admin.service.list')->with(response_status('Updated Successfully'));
    }

    public function destroy($uid) :RedirectResponse{

        $response = response_status('Service Not Found', 'error');
        $service = Service::where('uid', $uid)->firstOrFail();

        if($service){
            $response =  response_status('Service Deleted');
            $this->fileService->unlink( config("settings")['file_path']['service_method']['path'],@$service->file->name);
            $service->file()->delete();
            $service->delete();
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
            'bulk_id.*' => ['exists:services,id'],
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
        $response = $this->serviceService->bulktAction( $request);
        return  back()->with($response);
    }
}
