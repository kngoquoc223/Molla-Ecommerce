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
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreUserCatalogueRequest;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository

    )
    {
        $this->userCatalogueService=$userCatalogueService;
        $this->userCatalogueRepository=$userCatalogueRepository;
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
        $userCatalogues = $this->userCatalogueService->paginate($request);
        $config['seo']=config('apps.userCatalogue');
        $template = 'backend.users.catalogue.index';
        return view('backend.dashboard.layout',compact(
            'template',
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

        $config['method']='create';
        $template = 'backend.users.catalogue.store';
        $config['seo']=config('apps.userCatalogue');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreUserCatalogueRequest $request){
        if($this->userCatalogueService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('user.catalogue.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('user.catalogue.index');
    }
    public function edit($id){
        $userCatalogue=$this->userCatalogueRepository->findById($id);
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
        $template = 'backend.users.catalogue.store';
        $config['seo']=config('apps.userCatalogue');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'userCatalogue',
        ));
    }
    public function update($id, StoreUserCatalogueRequest $request){
        if($this->userCatalogueService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('user.catalogue.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('user.catalogue.index');
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
        ];
        $config['seo']=config('apps.userCatalogue');
        $userCatalogue=$this->userCatalogueRepository->findById($id);
        $template = 'backend.users.catalogue.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'userCatalogue',
            'config',
        ));
    }
    public function destroy($id){
        if($id != 1 && $id != 2){
            if($this->userCatalogueService->delete($id)){
                toastr()->success('Xóa bản ghi thành công.');
                return redirect()->route('user.catalogue.index');
            }
            toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('user.catalogue.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để xóa nhóm này.');
            return redirect()->route('user.catalogue.index');
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
