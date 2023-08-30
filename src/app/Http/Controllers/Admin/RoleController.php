<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Http\Services\RoleService;

;
use Illuminate\View\View;

class RoleController extends Controller
{
    private $roleService;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->roleService = new RoleService();
        //check permissions middleware
        $this->middleware(['permissions:view_role'])->only('index');
        $this->middleware(['permissions:create_role'])->only(['store','create']);
        $this->middleware(['permissions:update_role'])->only(['updateStatus','update']);
        $this->middleware(['permissions:delete_role'])->only(['destroy']);

    }


    /**
     * Role list
     *
     * @return View
     */
    public function index() :View{

        return view('admin.role.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Roles'=> null],
            'title' => 'Manage Roles',
            'roles' => request()->routeIs('admin.role.list') ? Role::with(['createdBy', 'updatedBy'])->filter()->latest()->get()
                : Role::onlyTrashed()->with(['createdBy', 'updatedBy'])->filter()->latest()->get()

        ]);
    }


    /**
     * Role Create View
     *
     * @return View
     */
    public function create() :View{

        return view('admin.role.create',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Roles'=> "admin.role.list",'Create'=> null],
            'title' => 'Create Role',
        ]);
    }


    /**
     * store a  new role
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse{

        $request->validate([
            'name'=>'required|unique:roles,name',
            'permissions'=>'required|array',
        ]);

        $permissions = array();

        foreach ($request->permissions as $key => $value) {
            $permissions[$key] = array_values($value);
        }
        Role::create([
            'name' => $request->input("name"),
            'permissions' => json_encode($permissions),
            'created_by' => auth_user()->id,
            'status' => StatusEnum::true->status()
        ]);

        return  back()->with(response_status('Role Created Successfully'));
    }


    /**
     * show edit form for a specific role
     *
     * @return RedirectResponse,View
     */
    public function edit(int | string $uid) :View | RedirectResponse{

        $role  = Role::where('uid',$uid)->firstOrFail();

        return view('admin.role.edit',[
            'title' => 'Update Role',
            'breadcrumbs' =>  ['Home'=>'admin.home','Roles'=> "admin.role.list",'Update'=> null],
            'role' => $role
        ]);
    }


    /**
     * Update a specific role
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse{

        $request->validate([
            'id'=>'required|exists:roles,id',
            'name'=>'required|unique:roles,name,'.$request->id,
            'permissions'=>'required|array',
        ]);

        $permissions = array();
        foreach ($request->permissions as $key => $value) {
            $permissions[$key] = array_values($value);
        }
        Role::where('id',$request->id)->update([
            'name' => $request->input("name"),
            'updated_by' => auth_user()->id,
            'permissions' => json_encode($permissions)
        ]);
        return  back()->with(response_status('Role Updated Successfully'));
    }


    /**
     * Updates the status of a specif role.
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:roles,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ],[
            'data.id.required'=>translate('The Id Field Is Required')
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate(Arr::get(config('language'),'updated_successfully','Updated'));

        $role = Role::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id,
        ]);

        if(!$role){
            $response['status'] = false;
            $response['message'] = translate(Arr::get(config('language'),'failed_to_update','Fail To Update'));
        }


        return json_encode($response);
    }


    /**
     * destroy a specific role
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy( $id) :RedirectResponse{

        $role  = Role::withCount('staff')->where('id',$id)->first();
        $response =  response_status('Role Not Found','error');
        if($role){
            $response =  response_status('Role Has Staff Under It!!','error');
            if($role->staff_count ==  0){
                $response =  response_status('Deletd Successfully');
                $role->delete();
            }

        }
        return  back()->with($response);
    }
    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Role Not Found', 'error');
        $role = Role::onlyTrashed()->where('id', $id)->firstOrFail();
        if($role->trashed()){
            $response =  response_status('Role Deleted');
            $role->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $role = Role::onlyTrashed()->where('id', $id)->firstOrFail();
        $role->restore();
        $response =  response_status('Role Restored');
        return redirect()->route('admin.role.archive')->with($response);
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
            'bulk_id.*' => ['exists:roles,id'],
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

        $response = $this->roleService->bulktAction( $request);

        return  back()->with($response);
    }

}


