<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View ;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\User\AuthService;
use App\Models\Admin;

class NewPasswordController extends Controller
{
    private $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }


    /**
     * forget password 
     *
     * @return View
     */
    public function create():View{

        return view('admin.auth.forgot_password',[
            'title'=> "Reset Passsword",
        ]);
    }


    /**
     * forget password 
     *
     * @return mixed
     */
    public function store(Request $request):mixed{

        $request->validate([
            'email' => "required|email|exists:admins,email"
        ]);
        $message = response_status("Invalid Email","error");
        $admin = Admin::where('email',$request->email)->first();
        if($admin){
            $response =  $this->authService->passwordReset($admin);
            $message = response_status('Can\'t Sent Email!! Configuration Error' , "error");
            if($response['status']){
                $request->session()->flash('success', translate("Check your email a code sent successfully for verify reset password process !! You Need To Verify Your Account!!"));
                session()->put("admin_reset_password_email",$admin->email);
                return redirect()->route("admin.password.verify");
            }
        }

        return redirect()->back()->with($message);
    }
    


    /**
     * return verification route
     *
     * @return View
     */
    public function verify() :View{

        return view("admin.auth.verify",[
            'title'=> "Verify Your Email",
        ]);
    }


    /**
     * verify code
     *
     * @return mixed
     */
    public function verifyCode(Request $request) :mixed {

        $request->validate([
            'email' => "required|email|exists:admins,email",
            'code' => "required",
        ]);      

        $message = response_status("Invalid Code","error");
        $admin = Admin::with("otp")->where('email',$request->email)->first();
        if($admin && $admin->email == session()->get("admin_reset_password_email")){
            $adminOtp = $admin->otp()?->where('type','admin_password_reset')->first();
            if($adminOtp && $adminOtp->otp == $request->get("code")){
               session()->put("reset_password_otp",$adminOtp->otp);
               return redirect()->route('admin.password.reset');
            }
        }
        return redirect()->back()->with($message);
    }

    /**
     * reset view
     *
     * @return View
     */
    public function resetPassword () :View{

        return view("admin.auth.reset",[
    
            'title'=> "Reset Your Password",
        ]);
    }


    /**
     * update password 
     *
     * @return View
     */
    public function updatePassword(Request $request) :RedirectResponse {

        $request->validate([
            'password' => ['required', 'confirmed', 'min:5']
        ]);

        $admin = Admin::with("otp")->where('email',session()->get("admin_reset_password_email"))->first();
        $adminOtp = $admin->otp()?->where('type','admin_password_reset')->first();
        if($admin && $adminOtp->otp == session()->get("reset_password_otp")){
            $admin->password = Hash::make($request->get('password'));
            $admin->save();
            session()->forget("admin_reset_password_email");
            session()->forget("reset_password_otp");
            $admin->otp()?->where('type','admin_password_reset')->delete();
            return redirect()->route('admin.login')->with(response_status("Your Password Has Been Updated!!"));
        }
        return back()->with(response_status("Invalid Otp or Email",'error'));
    }

}
