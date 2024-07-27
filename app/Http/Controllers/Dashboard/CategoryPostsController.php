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
use App\Services\Interfaces\CategoryPostsServiceInterface as CategoryPostsService;
use App\Repositories\Interfaces\CategoryPostsRepositoryInterface as CategoryPostsRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreCategoryPostsRequest;
use App\Http\Requests\UpdateCategoryPostsRequest;
use Illuminate\Support\Facades\Auth;

class CategoryPostsController extends Controller
{
    protected $categoryPostsService;
    protected $categoryPostsRepository;
    public function __construct(
        CategoryPostsService $categoryPostsService,
        CategoryPostsRepository $categoryPostsRepository

    )
    {
        $this->categoryPostsService=$categoryPostsService;
        $this->categoryPostsRepository=$categoryPostsRepository;
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
        $categoryPosts = $this->categoryPostsService->paginate($request);
        $config['seo']=config('apps.categoryPosts');
        $template = 'backend.categoryPosts.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'categoryPosts',
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
                '/backend/js/simple.money.format.js',
            ]
        ];

        $config['method']='create';
        $template = 'backend.categoryPosts.store';
        $config['seo']=config('apps.categoryPosts');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreCategoryPostsRequest $request){
        if($this->categoryPostsService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('categoryPosts.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('categoryPosts.index');
    }
    public function edit($id){
        $categoryPosts=$this->categoryPostsRepository->findById($id);
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/location.js',
                '/backend/js/simple.money.format.js',
            ]
        ];
        $config['method']='edit';
        $template = 'backend.categoryPosts.store';
        $config['seo']=config('apps.categoryPosts');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'categoryPosts',
        ));
    }
    public function update($id, UpdateCategoryPostsRequest $request){
        if($this->categoryPostsService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('categoryPosts.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('categoryPosts.index');
    }
    public function destroy(Request $request){
        if(Auth::id()==1){
            $get=$request->input();
            if($this->categoryPostsService->delete($get['id'])){
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
