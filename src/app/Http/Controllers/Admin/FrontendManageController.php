<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeoRequest;
use App\Http\Services\FrontendService;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use App\Models\Admin\Frontend;
use App\Models\Core\File;
use App\Models\Seo;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FrontendManageController extends Controller
{

    private  $frontEndService;

    /**
     *
     * @return void
     */
    public function __construct()
    {

        $this->frontEndService = new FrontendService();
        $this->middleware(['permissions:view_frontend'])->only('index','seo','vistor',);
        $this->middleware(['permissions:update_frontend'])->only(['update','edit','updateSeo','destroyIp']);
    }



    /**
     * manage frontend
     *
     * @return View
     */
    public function index() :View
    {

        return view('admin.frontend.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Frontends'=> null],
            'title' => 'Manage Frontend',
            'frontends' =>  Frontend::orderBy('id')->get()
        ]);

    }


    /**
     * update forntend section
     */

     public function update(Request $request) :RedirectResponse
     {
        $request->validate([
           "id" => "required|exists:frontends,id",
           'status'=> [Rule::in(StatusEnum::toArray())],
        ]);

         $frontend = Frontend::with(['file'])->where('id',$request->id)->firstOrfail();
         $section_values = ($frontend->value);
         $input_data = $request->get("frontend");
         $validation = [];

         $imageKeys = ['banner_image', 'image', 'icon_image'];


         foreach ($imageKeys as $element) {

             if (isset($section_values->static_element->{$element})) {
                 $size = $section_values->static_element->{$element}->size;
                 $validationRules["frontend.static_element.{$element}.value"] = [
                     "image",
                     new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true)),
                     new FileLengthCheckRule($size),
                 ];
                 $request->validate($validationRules);
                 $input_data['static_element'][$element]['value'] = $section_values->static_element->{$element}->value;
             }

             if($request->hasFile('frontend.static_element.'.$element.'.value')){
                 try{
                     if($frontend->slug == 'about_section'){
                         $oldFille = @$frontend->file->where('type',$element)->first()?->name;
                     }
                     else{
                         $oldFille = @$frontend->file->name;
                     }

                     $response = FileService::storeFile($request->file('frontend.static_element.'.$element.'.value'), config("settings")['file_path']['frontend']['path'],null,@$oldFille);

                     if($response['status']){

                         $image = new File();
                         if($frontend->slug == 'about_section'){
                             $frontend->file->where('type',$element)->delete();
                             $image->type = $element;
                         }
                         else{
                             $frontend->file()->delete();
                         }

                         $image->name =  Arr::get( $response ,'name',"#");
                         $image->disk =  Arr::get( $response ,'disk',"local");

                         $frontend->file()->save($image);
                     }

                 }catch (\Exception $exp){
                     return back()->with(response_status("File Upload Faild!! Check Your Folder Permissions!!",'error'));
                 }

                 $input_data['static_element'][$element]['value'] =    Arr::get( $response ,'name',"#") ;

             }
         }


         $frontend->status =  $request->status;
         $frontend->value = ($input_data);
         $frontend->updated_by = auth_user()->id;
         $frontend->save();

         optimize_clear();

         return back()->with(response_status("Frontend Section Updated Successfully"));


     }


    public function visitor(Request $request) :View
    {
        return view('admin.frontend.visitor',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Visitor'=> null],
            'title' => 'Manage Visitor',
            'visitors' => Visitor::filter()->with(['updatedBy'])->latest('updated_at')->paginate(paginateNumber())
        ]);

    }

    /**
     *  block or unblock a specific ip
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:visitors,id',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate(Arr::get(config('language'),'updated_successfully','Updated'));

        $visitor =  Visitor::where('id',$request->data['id'])->update([
            'is_blocked' => $request->data['status'] ,
            'updated_by' => auth_user()->id,
        ]);


        if(!$visitor){
            $response['status'] = false;
            $response['message'] = translate(Arr::get(config('language'),'failed_to_update','Fail To Update'));
        }

        return json_encode($response);
    }

    /**
     * destroy a specific ip
     *
     * @param string $ip
     * @return RedirectResponse
     */
    public function destroyIp(string $ip) :RedirectResponse{

        $ip  = Visitor::where('ip_address',$ip)->firstOrfail();
        $response =  response_status('Ip Not Found','error');
        if($ip){
            $ip->delete();
            $response =  response_status('Ip Deleted');
        }
        return  back()->with($response);
    }
    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Visitor Not Found', 'error');
        $ip = Visitor::onlyTrashed()->where('id', $id)->firstOrFail();
        if($ip->trashed()){
            $response =  response_status('Visitor Deleted');
            $ip->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $ip = Visitor::onlyTrashed()->where('id', $id)->firstOrFail();
        $ip->restore();
        $response =  response_status('Visitor Restored');
        return redirect()->route('admin.frontend.visitor.archive')->with($response);
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
            'bulk_id.*' => ['exists:visitors,id'],
            'type' => ['required', Rule::in(['delete', 'restore'])],
        ];
        $request->validate($rules);
        $response = $this->frontEndService->bulktAction( $request);
        return  back()->with($response);
    }


    /**
     * get seo settings
     *
     * @return View
     */
    public function seo() :View{

        return view('admin.seo.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Seos'=> null],
            'title' => 'Manage Seo',
            'seos' => Seo::filter()->orderBy('id','asc')->get()
        ]);
    }

    /**
     * edit seo settings
     *
     * @return View
     */
    public function edit(string  $uid) :View{

        return view('admin.seo.edit',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Seos'=> 'admin.seo.list' ,"Edit" => null],
            'title' => 'Update Seo',
            'seo' => Seo::where('uid',$uid)->first()
        ]);
    }

    public function updateSeo(SeoRequest $request) :RedirectResponse{

        $seo =  Seo::where('id',$request->id)->firstOrfail();

        $seo->title =  $request->get('title');
        if($seo->identifier != 'home'){
            $seo->slug =  make_slug($request->get('slug'));
        }
        $seo->meta_title =  $request->get('meta_title');
        $seo->meta_description =  $request->get('meta_description');
        $seo->meta_keywords =  $request->get('meta_keywords');
        $seo->updated_by =  auth_user()->id;
        $seo->save();
        optimize_clear();

        return  back()->with(response_status('Seo Settings Updated'));

    }
}
