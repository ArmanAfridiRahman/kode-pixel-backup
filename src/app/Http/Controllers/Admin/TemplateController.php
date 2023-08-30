<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Template;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Services\TemplateService;

class TemplateController extends Controller
{

    private $templateService;
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->templateService = new TemplateService();
        //check permissions middleware
        $this->middleware(['permissions:view_template'])->only('index');
        $this->middleware(['permissions:update_template'])->only(['edit','update','updateStatus']);
    }


    /**
     * template list
     *
     * @return View
     */
    public function index() :View{

        return view('admin.template.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Templates'=> null],
            'title' => 'Manage Template',
            'templates' => request()->routeIs('admin.template.list') ?
                Template::filter()->with(['createdBy','updatedBy'])->latest()->get():
                Template::onlyTrashed()->filter()->with(['createdBy','updatedBy'])->latest()->get()
        ]);
    }




    /**
     * global template
     *
     * @return View
     */
    public function global() :View{

        return view('admin.template.global',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Global Template'=> null],
            'title' => 'Manage Global Template',
        ]);
    }


    /**
     * update global template
     *
     * @return View
     */
    public function globalUpdate(Request $request) :RedirectResponse{

        $response = json_decode((new SettingController())->store($request),true);
        optimize_clear();
        return  back()->with(response_status($response['message'],$response['status'] ? "success" :"error"));
    }


    /**
     * update temaplate
     *
     * @return View
     */
    public function edit(int | string $uid) :View{


        return view('admin.template.edit',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Templates'=> "admin.template.list"],
            'title' => 'Update Template',
            'template' =>  Template::where('uid',$uid)->firstOrFail()
        ]);
    }

    /**
     * update template
     *
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse{

        $request->validate([
            'id'=>"required|exists:templates,id",
            'name'=>"required",
            'subject'=>"required",
        ]);

        $template = Template::where('id',$request->id)->first();
        $template->name = $request->get('name');
        $template->sms_body = $request->get('sms_body');
        $template->subject = $request->get('subject');
        $template->body = $request->get('body');
        $template->updated_by = auth_user()->id;
        $template->save();

        return  back()->with(response_status('Updated Successfully'));
    }

    /**
     * Update a specific template status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:templates,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);


        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate(Arr::get(config('language'),'updated_successfully','Updated'));

        $template  = Template::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);


        if(!$template){
            $response['status'] = false;
            $response['message'] = translate(Arr::get(config('language'),'failed_to_update','Fail To Update'));
        }


        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfully');
        return json_encode($response);
    }
    public function destroy($uid) :RedirectResponse{
        $temoplate = Template::where('uid', $uid)->firstOrFail();
        $response = response_status('Template Not Found', 'error');
        if($temoplate){
            $response =  response_status('Template Deleted');
            $temoplate->delete();
        }
        return back()->with($response);
    }
    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Template Not Found', 'error');
        $temoplate = Template::onlyTrashed()->where('id', $id)->firstOrFail();
        if($temoplate->trashed()){
            $response =  response_status('Template Deleted');
            $temoplate->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $temoplate = Template::onlyTrashed()->where('id', $id)->firstOrFail();
        $temoplate->restore();
        $response =  response_status('Template Restored');
        return redirect()->route('admin.template.archive')->with($response);
    }

    /**
     * Bulk action
     *
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
            'bulk_id.*' => ['exists:templates,id'],
            'type' => ['required', Rule::in(['status', 'delete', 'restore'])],
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
        $response = $this->templateService->bulktAction( $request);
        return back()->with($response);
    }

}
