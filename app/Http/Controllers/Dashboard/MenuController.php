<?php

namespace App\Http\Controllers\Dashboard;

USE Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\MenuServiceInterface as MenuService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreMenuRequest;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    protected $menuService;
    protected $menuRepository;
    public function __construct(
        MenuService $menuService,
        MenuRepository $menuRepository

    )
    {
        $this->menuService=$menuService;
        $this->menuRepository=$menuRepository;
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
        $menus = $this->menuService->paginate($request);
        $config['seo']=config('apps.menu');
        $template = 'backend.menus.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'menus',
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

        $config['method']='create';
        $template = 'backend.menus.store';
        $config['seo']=config('apps.menu');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreMenuRequest $request){
        if(Auth::user()->user_catalogue_id == 1){
            if($this->menuService->create($request)){
                toastr()->success('Thêm mới thành công.');
                return redirect()->route('menu.index');
            }
            toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
            return redirect()->route('menu.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
            return redirect()->route('menu.index');
        }
    }
    public function edit($id){
        $menu=$this->menuRepository->findById($id);
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
        $config['method']='edit';
        $template = 'backend.menus.store';
        $config['seo']=config('apps.menu');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'menu',
        ));
    }
    public function update($id, StoreMenuRequest $request){
        if(Auth::user()->user_catalogue_id == 1){
            if($this->menuService->update($id, $request)){
                toastr()->success('Cập nhật bản ghi thành công.');
                return redirect()->route('menu.index');
            }
            toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('menu.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
            return redirect()->route('menu.index');
        }
    }
    public function destroy(Request $request){
        if(Auth::user()->user_catalogue_id == 1){
            $get=$request->input();
            if($this->menuService->delete($get['id'])){
                return response()->json(['flag' => true]);
            }
            return response()->json(['flag' => false]);
        }else{
            return response()->json(['flag' => false,'messenger' => 'Đăng nhập quyền hệ thống để thực hiện chức năng này.']);
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
