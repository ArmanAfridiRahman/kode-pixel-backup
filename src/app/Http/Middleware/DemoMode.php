<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ignoreRouteList = ['admin.setting.status.update','admin.user.update'];
            if(env('APP_MODE') == 'demo'){ 
                if(!in_array(Route::currentRouteName(),$ignoreRouteList)){
        
                    if(request()->routeIs("*.update*")  || request()->routeIs("*.destroy*") || request()->routeIs("*.delete*") || request()->routeIs("*.mark*") ||  request()->routeIs("*.send*") ){
                        if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                            return response()->json(response_status('This Function Is Not Available For Website Demo Mode','error'), 403);
                        }
                        return back()->with(response_status('This Function Is Not Available For Website Demo Mode','error'));
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
      
        return $next($request);
    }
}
