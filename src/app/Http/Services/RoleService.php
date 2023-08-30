<?php
namespace App\Http\Services;

use App\Models\Admin\Role;
use App\Models\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RoleService
{
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated roles status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){
            Role::withTrashed()->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        elseif($request->get("type") == 'restore'){
            $response =  response_status('Roles have been successfully Restored.');
            $roles = Role::withTrashed()->whereIn('id',$bulkIds)->get();
            foreach($roles as $role){
                $this->restore($role->uid);
            }
        }
        else{
            $roles = Role::withTrashed()->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($roles as $roleChunks){
                foreach ($roleChunks as $role)
                $this->delete($role->uid);
            }
            $response =  response_status('Roles with no associated items have been successfully deleted.');
        }
        return $response;

    }

    public function delete($uid){
        $role = Role::withTrashed()->where('uid',$uid)->firstOrFail();
        if ($role->trashed()){
            $role->forceDelete();
        }
        else{
            $role->delete();
        }
    }
    public function restore($uid){
        $role = Role::withTrashed()->where('uid',$uid)->first();
        $role->restore();
    }
}
