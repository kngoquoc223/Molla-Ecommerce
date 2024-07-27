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
use App\Services\Interfaces\PostsServiceInterface as PostsService;
use App\Repositories\Interfaces\PostsRepositoryInterface as PostsRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StorePostsRequest;
use App\Models\CategoryPosts;

class PostsController extends Controller
{
    protected $postsService;
    protected $postsRepository;
    public function __construct(
        PostsService $postsService,
        PostsRepository $postsRepository

    )
    {
        $this->postsService=$postsService;
        $this->postsRepository=$postsRepository;
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
        $categories=CategoryPosts::all();
        $posts = $this->postsService->paginate($request);
        $config['seo']=config('apps.posts');
        $template = 'backend.posts.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'posts',
            'config',
            'categories',
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
        $template = 'backend.posts.store';
        $categoryPosts=CategoryPosts::where('publish',2)->get();
        $config['seo']=config('apps.posts');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'categoryPosts',
        ));
    }
    public function store(StorePostsRequest $request){
        if($this->postsService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('posts.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('posts.index');
    }
    public function edit($id){
        $posts=$this->postsRepository->findById($id);
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
        $categoryPosts=CategoryPosts::where('publish',2)->get();
        $config['method']='edit';
        $template = 'backend.posts.store';
        $config['seo']=config('apps.posts');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'posts',
            'categoryPosts',
        ));
    }
    public function update($id, StorePostsRequest $request){
        if($this->postsService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('posts.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('posts.index');
    }
    public function destroy(Request $request){
        $get=$request->input();
        if($this->postsService->delete($get['id'])){
            return response()->json(['flag' => true]);
        }
        return response()->json(['flag' => false]);
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
