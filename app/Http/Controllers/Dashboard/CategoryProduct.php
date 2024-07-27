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
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Services\CategoryProductService as CategoryProductService;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Models\CategoryProduct as ModelsCategoryProduct;
use App\Http\Requests\UpdateCategoryProductRequest;
use Illuminate\Support\Facades\Auth;

class CategoryProduct extends Controller
{
    protected $categoryProductRepository;
    protected $categoryProductService;
    public function __construct(
        CategoryProductService $categoryProductService,
        CategoryProductRepository $categoryProductRepository
    )
    {
        $this->categoryProductService= $categoryProductService;
        $this->categoryProductRepository= $categoryProductRepository;
    }
    public function getCategoriesProduct(){
        $categories=ModelsCategoryProduct::all();
        $listCategory=[];
        ModelsCategoryProduct::recursive($categories,$parents=0,$level=1,$listCategory);
        return $listCategory;
 
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
                '/backend/library/category.js',
                '/backend/js/plugins/switchery/switchery.js',
            ]
        ];
        $categoryProducts=$this->categoryProductService->paginate($request);
        $config['seo']=config('apps.category');
        $template = 'backend.categories.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'categoryProducts'
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
            ]
        ];
        $config['method']='create';
        $template = 'backend.categories.store';
        $config['seo']=config('apps.category');
        $parentCategorys=$this->categoryProductRepository->getParentCategory();
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'parentCategorys',
        ));
    }
    public function store(StoreCategoryProductRequest $request){
        if($this->categoryProductService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('categoryProduct.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('categoryProduct.index');
    }
    public function edit($id){
        $categoryProduct=$this->categoryProductRepository->findById($id);
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
            ]
        ];
        $config['method']='edit';
        $template = 'backend.categories.store';
        $config['seo']=config('apps.category');
        $parentCategorys=$this->categoryProductRepository->getParentCategory();
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'categoryProduct',
            'parentCategorys',
        ));
    }
    public function update($id, UpdateCategoryProductRequest $request){
        if($this->categoryProductService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('categoryProduct.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('categoryProduct.index');
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
            ]
        ];
        $config['seo']=config('apps.category');
        $categoryProduct=$this->categoryProductRepository->findById($id);
        $template = 'backend.categories.delete';
        if($categoryProduct->parent_id == 0){
            $childCategorys=$this->categoryProductRepository->findChildCategory($categoryProduct->id);
            return view('backend.dashboard.layout',compact(
                'template',
                'categoryProduct',
                'config',
                'childCategorys',
            ));
        }else
        {
            $parentCategory=$this->categoryProductRepository->findParentCategory($categoryProduct->parent_id);
            return view('backend.dashboard.layout',compact(
                'template',
                'categoryProduct',
                'config',
                'parentCategory',
            ));
        }

    }
    public function destroy($id){
        if(Auth::id()==1){
            if($this->categoryProductService->delete($id)){
                toastr()->success('Xóa bản ghi thành công.');
                return redirect()->route('categoryProduct.index');
            }
            toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('categoryProduct.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
            return redirect()->route('categoryProduct.index');
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
