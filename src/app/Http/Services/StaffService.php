<?php
namespace App\Http\Services;

use App\Models\Admin as Staff;
use App\Models\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StaffService
{

    private $fileService;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Staff bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated staffs status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){
            Staff::withTrashed()->with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        elseif($request->get("type") == 'restore'){
            $response =  response_status('Staffs have been successfully Restored.');
            $staffs = Staff::withTrashed()->with(['file'])->whereIn('id',$bulkIds)->get();
            foreach($staffs as $staff){
                $this->restore($staff->uid);
            }
        }
        else{
            $response =  response_status('Staffs have been successfully deleted.');
            $staffs = Staff::withTrashed()->with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));
            foreach($staffs as $staffChunks){
                foreach($staffChunks as $staff)
                $this->delete($staff->uid);
            }
        }
        return $response;

    }



    /**
     * delete a staff
     *
     * @param Staff $staff
     * @return void
     */
    public function delete($uid){
        $staff = Staff::withTrashed()->where('uid',$uid)->firstOrFail();
        if ($staff->trashed()){
            $this->fileService->unlink( config("settings")['file_path']['profile']['admin']['path'] ,@$staff->file->name );
            $staff->file()->delete();
            $staff->forceDelete();
        }
        else{
            $staff->delete();
        }
    }
    public function restore($uid){
        $staff = Staff::withTrashed()->where('uid',$uid)->first();
        $staff->restore();
    }
}
