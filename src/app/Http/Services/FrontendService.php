<?php
namespace App\Http\Services;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Visitor;

class FrontendService
{


    /**
     * Visitor bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated currency status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'restore'){
            $response =  response_status('Visitor have been successfully Restored.');
            $ips = Visitor::withTrashed()->whereIn('id',$bulkIds)->get();
            foreach($ips as $ip){
                $this->restore($ip->id);
            }
        }
        else{
            $response =  response_status('Visitor has been successfully deleted.');
            $ips = Visitor::withTrashed()->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));
            foreach($ips as $ipChunks){
                foreach ($ipChunks as $ip)
                $this->delete($ip->id);
            }
        }
        return $response;

    }

    public function delete($id){
        $ip = Visitor::withTrashed()->where('id',$id)->first();
        if ($ip->trashed()){
            $ip->forceDelete();
        }
        else{
            $ip->delete();
        }
    }
    public function restore($id){
        $ip = Visitor::withTrashed()->where('id',$id)->first();
        $ip->restore();
    }

}
