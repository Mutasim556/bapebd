<?php

namespace App\Http\Middleware\FrontEnd;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserStatusCheckMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()&&(Auth::user()->status==0 || Auth::user()->delete==1)){
            Auth::logout();
            return to_route('user.login','login')->with('banned',__('admin_local.Your accout has been banned.Please contact with admin'));
        }
        return $next($request);
    }
}
