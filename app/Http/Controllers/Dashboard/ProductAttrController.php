<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductAttrService as ProductAttrService;
use App\Repositories\Interfaces\ProductAttrRepositoryInterface as ProductAttrRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Http\Requests\StoreProductAttrRequest;

class ProductAttrController extends Controller
{
    protected $productAttrRepository;
    protected $productAttrService;
    protected $attributeRepository;
    public function __construct(
        ProductAttrService $productAttrService,
        ProductAttrRepository $productAttrRepository,
        AttributeRepository $attributeRepository,
    )
    {
        $this->attributeRepository=$attributeRepository;
        $this->productAttrService= $productAttrService;
        $this->productAttrRepository= $productAttrRepository;
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
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/js/plugins/switchery/switchery.js',
            ]
        ];
        $productAttrs=$this->productAttrService->paginate($request); 
        $config['seo']=config('apps.attribute');
        $template = 'backend.products.attributes.attribute.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'productAttrs',
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
        $template = 'backend.products.attributes.attribute.store';
        $config['seo']=config('apps.attribute');
        $attributeCatalogues=$this->attributeRepository->all();
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'attributeCatalogues'
        ));
    }
    public function store(StoreProductAttrRequest $request){
        if($this->productAttrService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('attribute.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('attribute.index');
    }
    public function edit($id){
        $productAttr=$this->productAttrRepository->findById($id);
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
        $template = 'backend.products.attributes.attribute.store';
        $config['seo']=config('apps.attribute');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'productAttr',
        ));
    }
    public function update($id, StoreProductAttrRequest $request){
        if($this->productAttrService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('attribute.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('attribute.index');
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
        ];
        $config['seo']=config('apps.attribute');
        $productAttr=$this->productAttrRepository->findById($id);
        $template = 'backend.products.attributes.attribute.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'productAttr',
            'config',
        ));
    }
    public function destroy($id){
        if($this->productAttrService->delete($id)){
            toastr()->success('Xóa bản ghi thành công.');
            return redirect()->route('attribute.index');
        }
        toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('attribute.index');
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
