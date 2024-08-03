<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttributeService as AttributeService;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Requests\StoreAttributeRequest;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{
    protected $attributeRepository;
    protected $attributeService;
    public function __construct(
        AttributeService $attributeService,
        AttributeRepository $attributeRepository
    )
    {
        $this->attributeService= $attributeService;
        $this->attributeRepository= $attributeRepository;
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
        $attributes=$this->attributeService->paginate($request);
        $config['seo']=config('apps.attributeCatalogue');
        $template = 'backend.products.attributes.catalogue.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'attributes'
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
        $template = 'backend.products.attributes.catalogue.store';
        $config['seo']=config('apps.attributeCatalogue');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreAttributeRequest $request){
        if(Auth::user()->user_catalogue_id == 1){
            if($this->attributeService->create($request)){
                toastr()->success('Thêm mới thành công.');
                return redirect()->route('attribute.catalogue.index');
            }
            toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
            return redirect()->route('attribute.catalogue.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
            return redirect()->route('attribute.catalogue.index');
        }
    }
    public function edit($id){
        $attribute=$this->attributeRepository->findById($id);
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
        $template = 'backend.products.attributes.catalogue.store';
        $config['seo']=config('apps.attributeCatalogue');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'attribute',
        ));
    }
    public function update($id, UpdateAttributeRequest $request){
        if(Auth::user()->user_catalogue_id == 1){
            if($this->attributeService->update($id, $request)){
                toastr()->success('Cập nhật bản ghi thành công.');
                return redirect()->route('attribute.catalogue.index');
            }
            toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('attribute.catalogue.index');
        }else{
                toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
                return redirect()->route('attribute.catalogue.index');
        }
    }
    public function delete($id){
        $config=[
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/backend/css/customize.css'
            ],
        ];
        $config['seo']=config('apps.attributeCatalogue');
        $attribute=$this->attributeRepository->findById($id);
        $template = 'backend.products.attributes.catalogue.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'attribute',
            'config',
        ));
    }
    public function destroy($id){
        if(Auth::user()->user_catalogue_id== 1){
            if($this->attributeService->delete($id)){
                toastr()->success('Xóa bản ghi thành công.');
                return redirect()->route('attribute.catalogue.index');
            }
            toastr()->error('Xóa bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('attribute.catalogue.index');
        }else{
            toastr()->error('Đăng nhập quyền hệ thống để thực hiện chức năng này.'); 
            return redirect()->route('attribute.catalogue.index');
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
