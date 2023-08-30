<?php
namespace App\Http\Services;

use App\Models\Admin\Template;
use App\Models\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TemplateService
{

    /**
     * Template bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated templates status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){
            Template::withTrashed()->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        elseif($request->get("type") == 'restore'){
            $response =  response_status('Templates have been successfully Restored.');
            $templates = Template::withTrashed()->whereIn('id',$bulkIds)->get();
            foreach($templates as $template){
                $this->restore($template->uid);
            }
        }
        else{
            $response =  response_status('Templates has successfully deleted.');
            $templates = Template::withTrashed()->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));
            foreach($templates as $templateChunks){
                foreach ($templateChunks as $template){
                    $this->delete($template->uid);
                }
            }
        }
        return $response;

    }
    public function restore($uid){
        $template = Template::withTrashed()->where('uid',$uid)->first();
        $template->restore();
    }

    public function delete($uid){
        $template = Template::withTrashed()->where('uid',$uid)->first();
        if ($template->trashed()){
            $template->forceDelete();
        }
        else{
            $template->delete();
        }
    }
}
