<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;
use Carbon\Carbon;
class UpdateLastLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $user = auth_user('web');
            $admin = auth_user();
            
            $currentTime = Carbon::now();
            
            if ($user) {
                $lastLoginTime = $user->last_login;
            
                if (!$lastLoginTime || $currentTime->diffInMinutes($lastLoginTime) >= 5) {
                    $user->update(['last_login' => $currentTime]);
                }
            }
            
            if ($admin) {
                $lastLoginTime = $admin->last_login;
            
                if (!$lastLoginTime || $currentTime->diffInMinutes($lastLoginTime) >= 5) {
                    $admin->update(['last_login' => $currentTime]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
       

        return $next($request);
    }
}
