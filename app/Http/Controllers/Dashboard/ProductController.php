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
use App\Services\ProductService as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRipository;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use App\Repositories\Interfaces\ProductAttrRepositoryInterface as ProductAttrRepository;
use App\Http\Requests\StoreProductRequest;
use App\Models\CategoryProduct as ModelsCategoryProduct;
use App\Services\ProductAttrService as ProductAttrService;
use App\Http\Requests\UpdateProductRequest;


class ProductController extends Controller
{
    protected $ProductRepository;
    protected $ProductService;
    protected $categoryProductRepository;
    protected $attributeRipository;
    protected $productAttrService;
    protected $attributeValueRepository;
    protected $productAttrRepository;
    public function __construct(
        ProductAttrRepository $productAttrRepository,
        AttributeValueRepository $attributeValueRepository,
        AttributeRipository $attributeRipository,
        ProductService $ProductService,
        ProductRepository $ProductRepository,
        CategoryProductRepository $categoryProductRepository,
        ProductAttrService $productAttrService,
    )
    {
        $this->productAttrRepository=$productAttrRepository;
        $this->attributeValueRepository=$attributeValueRepository;
        $this->productAttrService=$productAttrService;
        $this->attributeRipository =$attributeRipository;
        $this->ProductService= $ProductService;
        $this->ProductRepository= $ProductRepository;
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
                '/backend/library/library.js',
                '/backend/js/plugins/switchery/switchery.js',
            ]
        ];
        $categories=$this->getCategoriesProduct();
        $products=$this->ProductService->paginate(($request));
        $config['seo']=config('apps.product');
        $template = 'backend.products.product.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'products',
            'categories',
        ));
    }
    public function create(){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css',
            ],
            'js' => [
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/getCategories.js',
                '/backend/js/simple.money.format.js'
            ]
        ];
        $config['method']='create';
        $template = 'backend.products.product.store';
        $config['seo']=config('apps.product');
        $listCategory=$this->categoryProductRepository->getParentCategory();
        $attributeValues=$this->attributeValueRepository->all();
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'listCategory',
            'attributeValues',
        ));
    }
    public function store(StoreProductRequest $request){
        if($this->ProductService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('product.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('product.index');
    }
    public function edit($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
            'js' => [
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/library/getCategories.js',
                '/backend/js/simple.money.format.js'
            ]
        ];
        $config['method']='edit';
        $template = 'backend.products.product.store';
        $product=$this->ProductRepository->findById($id);
        $attrs=$this->productAttrRepository->findAttrProduct($product->id);
        $attributeValues=$this->attributeValueRepository->all();
        $listCategory=$this->categoryProductRepository->getParentCategory();
        $config['seo']=config('apps.product');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'product',
            'listCategory',
            'attributeValues',
            'attrs',
        ));
    }
    public function update($id, UpdateProductRequest $request){
        if($this->ProductService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('product.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('product.index');
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
        ];
        $config['seo']=config('apps.product');
        $product=$this->ProductRepository->findById($id);
        $template = 'backend.products.product.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'product',
            'config',
        ));
    }
    public function destroy($id){
        if($this->ProductService->delete($id)){
            toastr()->success('Xóa bản ghi thành công.');
            return redirect()->route('product.index');
        }
        toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('product.index');
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
