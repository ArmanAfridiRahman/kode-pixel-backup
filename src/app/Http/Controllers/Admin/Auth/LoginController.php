<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Auth\LoginController as AuthLoginController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;


class LoginController extends Controller
{
    
    /**
     * show login form
     *
     * @return void
     */
    public function login() :View{
        return view("admin.auth.login",[
            'title' => 'Login'
        ]);
    }

    
    /**
     * authenticate request user
     *
     * @param Request $request
     * @return void
     */
    public function authenticate(Request $request) :RedirectResponse{
        // dd($request->all());
        $response = response_status('Server Error!! Please Reload Then Try Again ','error');
        try {
            $this->validateLogin($request);
            $field  = $this->username($request->input('login'));
            
            if (Auth::guard('admin')->attempt([$field => $request->input('login') , "password"=>$request->input('password')])){
                return redirect()->intended('/admin/dashboard')->with(response_status('Successfully Loggedin'));
            }

            $response = response_status('Invalid Credential','error');
           
        } catch (\Throwable $th) {
            return back()->with(response_status('Server Error!!','error'));
        }
        return back()->with($response);
       
    }

    /**
     * get username
     *
     * @param string $login
     * @return string
     */
    
     public function username(string $login) :string 
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } elseif (preg_match('/^[0-9]+$/', $login)) {
            return 'phone_number';
        }
        return 'user_name';
    }

    /**
     * Validate the admin login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ],[
            'login.required' => ucfirst($this->username($request)). translate(' Feild Is Required'),
            'password.required' => translate("Password Feild Is Required")
        ]);

    }

    /**
     * logout
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request) :RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }

    public function staffLogin() :View{
       
        return view("staff.auth.login",[
            'title' => 'Staff Login'
        ]);
    }

    public function authenticateStaff(Request $request){
        
        $response = response_status('Server Error!! Please Reload Then Try Again ','error');
        try {   
            $this->validateLogin($request);
            $field  = $this->username($request->input('login'));
            
            if (Auth::guard('staff')->attempt([$field => $request->input('login') , "password"=>$request->input('password')])){
               
                return redirect()->intended('/staff/dashboard')->with(response_status('Successfully Loggedin'));
            }

            $response = response_status('Invalid Credential','error');
           
        } catch (\Throwable $th) {
            return back()->with(response_status('Server Error!!','error'));
        }
        return back()->with($response);
       
    }
    public function logoutStaff(Request $request) :RedirectResponse
    {
        Auth::guard('staff')->logout();
        $request->session()->regenerateToken();
        return redirect('staff/');
    }

}
