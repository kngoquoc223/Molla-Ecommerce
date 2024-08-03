<?php

namespace App\Http\Controllers\Dashboard;

USE Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Role;
use App\Models\UserCatalogue;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\UpdateInfoUserRequest;
use App\Http\Requests\UpdateEmailUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;
    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository

    )
    {
        $this->userService=$userService;
        $this->provinceRepository=$provinceRepository;
        $this->userRepository=$userRepository;
    }
    public function info($id){
        $user=$this->userRepository->findById($id);
        $userCatalogues=UserCatalogue::where('publish',2)->get();
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/location.js',
            ]
        ];
        $provinces = $this->provinceRepository->all();
        $config['method']='edit';
        $template = 'backend.users.user.info';
        $config['seo']=config('apps.user');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'provinces',
            'user',
            'userCatalogues',
        ));
    }
    public function changeInfo(UpdateInfoUserRequest $request,$id){
        if($this->userService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->back();
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->back();
    }
    public function changeEmail(UpdateEmailUserRequest $request,$id){
        if($this->userService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->back();
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->back();
    }
    public function changePassword(UpdatePasswordUserRequest $request,$id){
        $user=$this->userRepository->findById($id);
        if(Hash::check($request['password_old'],$user->password)){
            $request['password']=Hash::make($request['password']);
            if($this->userService->update($id, $request)){
                toastr()->success('Cập nhật bản ghi thành công.');
                return redirect()->back();
            }
            toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->back();
        }else{
            toastr()->error('Mật khẩu không chính xác.Vui lòng thử lại'); 
            return redirect()->back();
        }
    }
    public function index(Request $request){
        $config=$this->config();
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css',
                '/backend/css/plugins/switchery/switchery.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/js/plugins/switchery/switchery.js',
            ]
        ];
        $users = $this->userService->paginate($request);
        $userCatalogues=UserCatalogue::all();
        $config['seo']=config('apps.user');
        $template = 'backend.users.user.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'users',
            'userCatalogues',
            'config',
        ));
    }
    public function create(){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/location.js',
            ]
        ];
        $provinces = $this->provinceRepository->all();
        $config['method']='create';
        $template = 'backend.users.user.store';
        $userCatalogues=UserCatalogue::where('publish',2)->get();
        $config['seo']=config('apps.user'); 
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'provinces',
            'userCatalogues',
        ));
    }
    public function store(StoreUserRequest $request){
        if($this->userService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('user.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('user.index');
    }
    public function edit($id){
        $user=$this->userRepository->findById($id);
        $userCatalogues=UserCatalogue::where('publish',2)->get();
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/location.js',
            ]
        ];
        $provinces = $this->provinceRepository->all();
        $config['method']='edit';
        $template = 'backend.users.user.store';
        $config['seo']=config('apps.user');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'provinces',
            'user',
            'userCatalogues',
        ));
    }
    public function update($id, UpdateUserRequest $request){
        if(Auth::user()->user_catalogue_id == 1){
            if($this->userService->update($id, $request)){
                toastr()->success('Cập nhật bản ghi thành công.');
                return redirect()->route('user.index');
            }
            toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('user.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.');
            return redirect()->route('user.index');
        }
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
        ];
        $config['seo']=config('apps.user');
        $user=$this->userRepository->findById($id);
        $template = 'backend.users.user.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'user',
            'config',
        ));
    }
    public function destroy($id){
        if($id != 1){
            if($this->userService->delete($id)){
                toastr()->success('Xóa bản ghi thành công.');
                return redirect()->route('user.index');
            }
            toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('user.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để xóa người dùng này.');
            return redirect()->route('user.index');
        }
    }
    private function config(){
        return [
            'js'=>[
                '/backend/js/sb-admin-2.min.js',
                '/backend/vendor/chart.js/Chart.min.js',
                '/backend/js/demo/chart-area-demo.js',
                '/backend/js/demo/chart-pie-demo.js',
                '/backend/library/library.js',
            ]
            ];
    }
}
