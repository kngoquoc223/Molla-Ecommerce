<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use WindowsAzure\Common\Internal\Validate;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\role;
use App\Models\Role as ModelsRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{

    public function showFormRegister (){
        return view('backend.auth.register');
    }
    public function register (AuthRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone,
            'user_catalogue_id' => 3,
            'publish' => 2,
        ]);
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('show-dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }
    public function index(){
        return view('backend.auth.login');
    }
    public function login(AuthLoginRequest $request){
            if(Auth::attempt(['email' => $request->email,'password' => $request->password ,'user_catalogue_id' => 1,'publish' => 2])){
                toastr()->success('Đăng nhập thành công.');
                return redirect()->route('show-dashboard');
            }
            else if(Auth::attempt(['email' => $request->email,'password' => $request->password ,'user_catalogue_id' => 3,'publish' => 2])){
                toastr()->success('Đăng nhập thành công.');
                return redirect()->route('show-dashboard');
            }
            toastr()->error('Email hoặc Mật khẩu không chính xác.');
            return back();
        }
        public function logout(Request $request)
        {
            Auth::logout();
         
            $request->session()->invalidate();
         
            $request->session()->regenerateToken();
         
            return redirect('admin/login');
        }
}
