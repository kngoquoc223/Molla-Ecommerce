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
use App\Services\Interfaces\CouponServiceInterface as CouponService;
use App\Repositories\Interfaces\CouponRepositoryInterface as CouponRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreCouponRequest;

class CouponController extends Controller
{
    protected $couponService;
    protected $couponRepository;
    public function __construct(
        CouponService $couponService,
        CouponRepository $couponRepository

    )
    {
        $this->couponService=$couponService;
        $this->couponRepository=$couponRepository;
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
        $coupons = $this->couponService->paginate($request);
        $config['seo']=config('apps.coupon');
        $template = 'backend.coupons.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'coupons',
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
        $template = 'backend.coupons.store';
        $config['seo']=config('apps.coupon');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }
    public function store(StoreCouponRequest $request){
        if($this->couponService->create($request)){
            toastr()->success('Thêm mới thành công.');
            return redirect()->route('coupon.index');
        }
        toastr()->error('Thêm mới không thành công. Vui lòng thử lại.'); 
        return redirect()->route('coupon.index');
    }
    public function edit($id){
        $coupon=$this->couponRepository->findById($id);
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
        $template = 'backend.coupons.store';
        $config['seo']=config('apps.coupon');
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'coupon',
        ));
    }
    public function update($id, StoreCouponRequest $request){
        if($this->couponService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công.');
            return redirect()->route('coupon.index');
        }
        toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
        return redirect()->route('coupon.index');
    }
    public function destroy(Request $request){
        $get=$request->input();
        if($this->couponService->delete($get['id'])){
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
