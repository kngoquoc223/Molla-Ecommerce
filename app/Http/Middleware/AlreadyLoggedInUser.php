<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Session;


class AlreadyLoggedInUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Session::get('customer') != null  ){
            toastr()->error('Đăng xuất tài khoản hiện tại để tiếp tục.'); 
            return redirect()->route('home.index');
        }
        return $next($request);
    }
}