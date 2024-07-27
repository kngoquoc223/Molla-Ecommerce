<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::id() == null){
            return redirect()->route('show-from-login')->with('error','Vui lòng đăng nhập.');
        }else{
            $user = User::where('id',Auth::id())->where('publish',2)->first();
            if($user===null){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                if($request->ajax()){
                    return false;
                }
                toastr()->error('Tài khoản của bạn đã bị chặn. Liên hệ Admin để biết thêm chi tiết');
                return redirect('admin/login');
            }
        }
        return $next($request);
    }
}
