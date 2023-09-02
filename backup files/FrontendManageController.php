<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use App\Models\Admin\Frontend;
use App\Models\Core\File;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FrontendManageController extends Controller
{

    /**
    * manage frontend
    *
    * @return View
    */
    public function index() :View {

        return view('admin.frontend.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Frontends'=> null],
            'title' => 'Manage Frontend',
            'frontends' =>  Frontend::orderBy('id')->get()
        ]);
    }

    /**
    * update forntend section
    */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            "id" => "required|exists:frontends,id",
            'status'=> [Rule::in(StatusEnum::toArray())],
        ]);

        $frontend = Frontend::with(['file'])->where('id',$request->id)->firstOrfail();
        $section_values = ($frontend->value);
        $input_data = $request->get("frontend");
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

            if($request->hasFile('frontend.static_element.'.$element.'.value' || 'frontend.dynamic_element.'.$element.'.value')){
                try{
                    $oldFille = @$frontend->file->name;
                    $response = FileService::storeFile($request->file('frontend.static_element.'.$element.'.value' || 'frontend.dynamic_element.'.$element.'.value'), config("settings")['file_path']['frontend']['path'],null,@$oldFille);

                    if($response['status']){

                        $image = new File();
                        $frontend->file()->delete();
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
        $frontend->save();

        optimize_clear();

        return back()->with(response_status("Frontend Section Updated Successfully"));
    }
}
