<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttributeValueService as AttributeValueService;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use Illuminate\Support\Facades\Auth;

class AttributeValueController extends Controller
{
    protected $attributeValueRepository;
    protected $attributeValueService;
    protected $attributeRepository;
    public function __construct(
        AttributeValueService $attributeValueService,
        AttributeValueRepository $attributeValueRepository,
        AttributeRepository $attributeRepository
    )
    {
        $this->attributeRepository= $attributeRepository;
        $this->attributeValueService= $attributeValueService;
        $this->attributeValueRepository= $attributeValueRepository;
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
        $attributeValues=$this->attributeValueService->paginate($request);
        $attributeCatalogues=$this->attributeRepository->all();
        $config['seo']=config('apps.attribute');
        $template = 'backend.products.attributes.attribute.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'attributeValues',
            'attributeCatalogues'
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
            'attributeCatalogues',
        ));
    }
    public function store(StoreAttributeValueRequest $request){
        if(Auth::id()==1){
            if($this->attributeValueService->create($request)){
                toastr()->success('Thêm mới thành công.');
                return redirect()->route('attribute.index');
            }
            toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
            return redirect()->route('attribute.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.');
            return redirect()->route('attribute.index');
        }
    }
    public function edit($id){
        $attributeValue=$this->attributeValueRepository->findById($id);
        $attributeCatalogues=$this->attributeRepository->all();
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
            'attributeValue',
            'attributeCatalogues',
        ));
    }
    public function update($id, UpdateAttributeValueRequest $request){
        if($this->attributeValueService->update($id, $request)){
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
        $attributeValue=$this->attributeValueRepository->findById($id);
        $template = 'backend.products.attributes.attribute.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'attributeValue',
            'config',
        ));
    }
    public function destroy($id){
        if(Auth::id()==1){
            if($this->attributeValueService->delete($id)){
                toastr()->success('Xóa bản ghi thành công.');
                return redirect()->route('attribute.index');
            }
            toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('attribute.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.');
            return redirect()->route('attribute.index');
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
