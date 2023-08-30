<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Http\Services\FileService;
use App\Models\Admin as Staff;
use App\Models\Admin\Role;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Services\StaffService;

class StaffController extends Controller
{
    private $staffService;

    protected $fileService;
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->staffService = new StaffService();
        $this->fileService = new FileService();
        //check permissions middleware
        $this->middleware(['permissions:view_staff'])->only('index');
        $this->middleware(['permissions:create_staff'])->only(['store','create']);
        $this->middleware(['permissions:update_staff'])->only(['updateStatus','update','updatePassword','login']);
        $this->middleware(['permissions:delete_staff'])->only(['destroy']);
    }


    /**
     * Staff list
     *
     * @return View
     */
    public function index() :View{

        return view('admin.staff.index',[
            'roles' =>  Role::active()->latest()->pluck('id','name')->prepend(
                "",
                translate('Select Role')
            ),
            'breadcrumbs' =>  ['Home'=>'admin.home','Staffs'=> null],
            'title' => 'Manage Staff',
            'staffs' => request()->routeIs('admin.staff.list') ? Staff::with(['file', 'createdBy'])->filter()->staff()->latest()->paginate(paginateNumber())->appends(request()->all())
                : Staff::onlyTrashed()->with(['file', 'createdBy'])->filter()->latest()->paginate(paginateNumber())->appends(request()->all())
        ]);
    }


    /**
     * store a  new staff
     *
     * @param StaffRequest $request
     * @return RedirectResponse
     */
    public function store(StaffRequest $request) :RedirectResponse{
        // dd($request->all());
        $staff = Staff::create([
            'name' => $request->input("name"),
            'user_name' => $request->input("user_name"),
            'role_id' => $request->input("role_id"),
            'created_by' => auth_user()->id,
            'phone' => $request->input("phone"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input("password")),
            'status' => $request->input("status"),
        ]);

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['profile']['admin']['path'],null );
            if($response['status']){

                $image = new File();
                $image->name =  Arr::get( $response ,'name',"#");
                $image->disk =  Arr::get( $response ,'disk',"local");
                $staff->file()->save($image);
            }
        }
        return  back()->with(response_status('Staff Created Successfully'));
    }




    /**
     * Update a specific staff
     *
     * @param StaffRequest $request
     * @return RedirectResponse
     */
    public function update(StaffRequest $request) :RedirectResponse{

        $staff = Staff::with('file')->staff()->where('id',$request->id)->first();

        $staff->user_name =  $request->input("user_name");
        $staff->name =  $request->input("name");
        $staff->role_id =  $request->input("role_id");
        $staff->updated_by =  auth_user()->id;
        $staff->phone =  $request->input("phone");
        $staff->email =  $request->input("email");
        $staff->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['profile']['admin']['path'],null ,@$staff->file->name );
            if($response['status']){
                $staff->file()->delete();
                $image = new File();
                $image->name =  Arr::get( $response ,'name',"#");
                $image->disk =  Arr::get( $response ,'disk',"local");
                $staff->file()->save($image);
            }
        }

        return  back()->with(response_status('Staff Updated Successfully'));
    }

    /**
     * Update a specific staff status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:admins,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate(Arr::get(config('language'),'updated_successfully','Updated'));

        $staff = Staff::staff()->where('uid',$request->data['id'])->update([
            'status' => $request->data['status'] ,
            'updated_by' => auth_user()->id,
        ]);

        if(!$staff){
            $response['status'] = false;
            $response['message'] = translate(Arr::get(config('language'),'failed_to_update','Fail To Update'));
        }

        return json_encode($response);

    }


    /**
     * destroy a specific staff
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy($id) :RedirectResponse{

        $staff  = Staff::with(['file'])->staff()->where('id',$id)->first();
        $response =  response_status('Staff Not Found','error');
        if($staff){
            $response =  response_status('Deleted Successfully');
            $this->fileService->unlink( config("settings")['file_path']['profile']['admin']['path'],@$staff->file->name);
            $staff->file()->delete();
            $staff->delete();
        }

        return  back()->with($response);
    }


    /**
     * login in as staff
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function login(string $uid) :RedirectResponse{

        $staff  = Staff::staff()->where('uid',$uid)->firstOrFail();
        // $staff->status = StatusEnum::true->status();
        // $staff->save();

        Auth::guard('admin')->loginUsingId($staff->id);
        return redirect()->route('admin.home')->with(response_status('Successfully logged In As a Staff'));
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request) :RedirectResponse{

        $request->validate([
            'uid'=>'required|exists:admins,uid',
            'password'=>"required|confirmed|min:5"
        ]);

        Staff::staff()->where('uid',$request->uid)->update([
            'password'=> Hash::make($request->password)
        ]);

        return  back()->with(response_status('Password Updated'));

    }

    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Staff Not Found', 'error');
        $staff = Staff::onlyTrashed()->where('id', $id)->firstOrFail();
        if($staff->trashed()){
            $response =  response_status('Staff Deleted');
            $this->fileService->unlink( config("settings")['file_path']['profile']['admin']['path'],@$staff->file->name);
            $staff->file()->forceDelete();
            $staff->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $staff = Staff::onlyTrashed()->where('id', $id)->firstOrFail();
        $staff->restore();
        $response =  response_status('Staff Restored');
        return redirect()->route('admin.staff.archive')->with($response);
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
            'bulk_id.*' => ['exists:admins,id'],
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
        $response = $this->staffService->bulktAction( $request);
        return  back()->with($response);
    }

}
