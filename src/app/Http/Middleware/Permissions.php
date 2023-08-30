<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,string $permission): Response
    {

        try {
            if(!check_permission($permission)){
                if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                    return response()->json(['error' => unauthorized_message()], 403);
                }
                return redirect('/403');
            }
        } catch (\Exception $ex) {
           
        }
       
        return $next($request);
    }
}
