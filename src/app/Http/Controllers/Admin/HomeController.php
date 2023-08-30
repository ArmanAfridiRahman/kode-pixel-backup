<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Services\FileService;
use App\Models\Core\File;
use App\Models\Notification;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{


    /**
     * Admin Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request) :View{


        return view('admin.home',[
            'title' => "Dashboard",
            'data' => $this->getDashboardData($request)

        ]);
    }
    public function staffHome(Request $request) :View{


        return view('staff.home',[
            'title' => "Dashboard",

        ]);
    }


     /**
     * get dashboard data
     */

     public function getDashboardData($request =  null) :array{
        $data['total_visitor'] = Visitor::count();
        $data['visitor_by_months'] = sortByMonth(Visitor::selectRaw("MONTHNAME(created_at) as months, count(*) as total")
        ->whereYear('created_at', '=',date("Y"))
        ->groupBy('months')
        ->pluck('total', 'months')
        ->toArray());




        return $data;

     }



    /**
     * Admin profile
     *
     * @return View
     */
    public function profile() :View{
        return view('admin.profile',[
            'breadcrumbs' =>  ['home'=>'admin.home','profile'=> null],
            "user"=> auth_user(),
            'title' => "Profile",
        ]);
    }
    /**
     * Admin profile
     *
     * @return View
     */
    public function profileUpdate(ProfileRequest $request ) :RedirectResponse{

        $admin = auth_user();

        $admin->user_name = $request->get('user_name');
        $admin->phone = $request->get('phone');
        $admin->email = $request->get('email');
        $admin->name = $request->get('name');
        $admin->save();

        try {
            if($request->hasFile('image')){
                $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['profile']['admin']['path'],null ,@$admin->file->name );
                if($response['status']){
                    $admin->file()->delete();
                    $image = new File();
                    $image->name =  Arr::get( $response ,'name',"#");
                    $image->disk =  Arr::get( $response ,'disk',"local");
                    $admin->file()->save($image);
                }
            }
        } catch (\Throwable $th) {
            return back()->with(response_status('Can not upload image!! Check Your Directory Permissions','error'));
        }



        return back()->with(response_status('Profile Updated'));
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request ) :RedirectResponse{

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:5',
        ],
        [
            'current_password.required' => translate('Your Current Password is Required'),
            'password' => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min' => translate('Minimum 5 digit or character is required'),
        ]);
        $admin = auth_user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     */

     public function readNotification(Request $request) :string{

        $admin_notification = Notification::where("id", $request->id)
        ->whereNull('user_id')
        ->first();
        $status = false;
        $message = translate('Notification Not Found');
        if( $admin_notification ){
            $admin_notification->is_read =  (StatusEnum::true)->status();
            $admin_notification->save();
            $status = true;
            $message = translate('Notification Readed');
        }
        return json_encode([
            "status" => $status,
            "message" => $message
        ]);

    }


    /**
     * read a notifications
     */

     public function notification(Request $request) :View{
        Notification::whereNull('user_id')
        ->update([
            "is_read" =>  (StatusEnum::true)->status()
        ]);
        return view('admin.notification',[
            'breadcrumbs' =>  ['home'=>'admin.home','Notifications'=> null],
            'title' => "Notifications",
            'notifications' => Notification::whereNull('user_id')
            ->latest()
            ->paginate(paginateNumber())
        ]);


    }



}
