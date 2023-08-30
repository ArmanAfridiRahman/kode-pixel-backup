<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    
        try {

            $ipAddress = request()->ip();
            $ip = Visitor::where('ip_address', $ipAddress)->first();
            if (!$ip) {
                $ip = new Visitor();
                $ip->ip_address = $ipAddress;
            }

            $ip->agent_info = get_ip_info();
            $ip->save();

            if ($ip->is_blocked == StatusEnum::true->status()) {
                return redirect()->route('403')->with(response_status('Your IP is Blocked!', 'error'));
            }
           
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $next($request);
    }
}
