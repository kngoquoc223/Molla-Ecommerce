<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::get('customer') == null){
            toastr()->error('Vui lòng đăng nhập.');       
            return redirect()->route('home.user.showForm');
        }else{
            $user = User::where('id',Session::get('customer')->id)->where('publish',2)->first();
            if($user===null){
                toastr()->error('Tài khoản của bạn đã bị chặn.Vui lòng liên hệ Admin để biết thêm chi tiết');
                Session::forget('customer');
                if($request->ajax()){
                    return false;
                }
                return redirect()->route('home.user.showForm');
            }
        }
        return $next($request);
    }
}
