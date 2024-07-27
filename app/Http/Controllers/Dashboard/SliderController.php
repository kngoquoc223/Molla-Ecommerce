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
use App\Services\Interfaces\SliderServiceInterface as SliderService;
use App\Repositories\Interfaces\SliderRepositoryInterface as SliderRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreSliderRequest;

class SliderController extends Controller
{
    protected $sliderService;
    protected $sliderRepository;
    public function __construct(
        SliderService $sliderService,
        SliderRepository $sliderRepository

    )
    {
        $this->sliderService=$sliderService;
        $this->sliderRepository=$sliderRepository;
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
        $sliders = $this->sliderService->paginate($request);
        $config['seo']=config('apps.slider');
        $template = 'backend.sliders.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'sliders',
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
        $template = 'backend.sliders.store';
        $config['seo']=config('apps.slider');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreSliderRequest $request){
        if($this->sliderService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('slider.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('slider.index');
    }
    public function edit($id){
        $slider=$this->sliderRepository->findById($id);
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
        $template = 'backend.sliders.store';
        $config['seo']=config('apps.slider');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'slider',
        ));
    }
    public function update($id, StoreSliderRequest $request){
        if($this->sliderService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('slider.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('slider.index');
    }
    public function destroy(Request $request){
        $get=$request->input();
        if($this->sliderService->delete($get['id'])){
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
