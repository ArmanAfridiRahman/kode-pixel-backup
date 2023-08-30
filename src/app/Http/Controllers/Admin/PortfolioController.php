<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Http\Services\FileService;
use App\Models\Admin\Portfolio;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Http\Services\PortfolioService;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    private $fileService, $portfolioService;

    public function __construct(){
        $this->fileService = new FileService();
        $this->portfolioService = new PortfolioService();
        $this->middleware(['permissions:view_portfolio'])->only('index');
        $this->middleware(['permissions:create_portfolio'])->only('create');
        $this->middleware(['permissions:update_portfolio'])->only('edit', 'update');
        $this->middleware(['permissions:delete_portfolio'])->only('destroy');
    }

    public function index(Request $request) :View {
        
        return view('admin.portfolio.index', [
            'title' => 'Portfolio List',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Portfolio' => 'admin.portfolio.list'],
            'portfolios' => Portfolio::with(['createdBy', 'updatedBy'])->filter($request)->latest()->get()                                       
        ]);
    }

    public function create() :View{
        return view('admin.portfolio.create', [
            'title' => 'Portfolio',
            'breadcrumbs' =>  ['Dashboard' => 'admin.home', 'Portfolio' => 'admin.portfolio.list', 'Create' => null],
        ]);
    }

    public function edit(int | string $uid) :View{
        return view('admin.portfolio.edit', [
            'title' => 'Portfolio',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Portfolio' => 'admin.portfolio.list'],
            'portfolio' => Portfolio::where('uid', $uid)->first(),
        ]);
    }

    public function store(PortfolioRequest $request) :RedirectResponse{
        $portfolio = $this->portfolioService->save($request);
        return redirect()->route('admin.portfolio.list')->with(response_status('Updated Successfully'));
    }


    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:portfolios,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);
        Portfolio::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfuly');
        return json_encode($response);
    }

    public function update(PortfolioRequest $request) :RedirectResponse{
        $portfolio = $this->portfolioService->update($request);
        return redirect()->route('admin.portfolio.list')->with(response_status('Updated Successfully'));
    }

    public function destroy($uid) :RedirectResponse{

        $response = response_status('Portfolio Not Found', 'error');
        $portfolio = Portfolio::where('uid', $uid)->firstOrFail();

        if($portfolio){
            $response =  response_status('Portfolio Deleted');
            $this->fileService->unlink( config("settings")['file_path']['portfolio_method']['path'],@$portfolio->file->name);
            $portfolio->file()->delete();
            $portfolio->delete();
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
            'bulk_id.*' => ['exists:portfolios,id'],
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
        $response = $this->portfolioService->bulktAction( $request);
        return  back()->with($response);
    }
}
