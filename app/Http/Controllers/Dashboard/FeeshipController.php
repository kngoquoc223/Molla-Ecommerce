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
use App\Services\Interfaces\FeeshipServiceInterface as FeeshipService;
use App\Repositories\Interfaces\FeeshipRepositoryInterface as FeeshipRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreCouponRequest;
use App\Models\Feeship;

class FeeshipController extends Controller
{
    protected $feeshipService;
    protected $feeshipRepository;
    protected $provinceRepository;
    public function __construct(
        FeeshipService $feeshipService,
        FeeshipRepository $feeshipRepository,
        ProvinceRepository $provinceRepository,

    )
    {
        $this->feeshipService=$feeshipService;
        $this->feeshipRepository=$feeshipRepository;
        $this->provinceRepository=$provinceRepository;
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
                'https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                'https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/backend/library/library.js',
                '/backend/js/plugins/switchery/switchery.js',
                '/backend/library/location.js',
                '/backend/js/simple.money.format.js',
            ]
        ];
        $feeships = $this->feeshipService->paginate($request);
        $provinces = $this->provinceRepository->all();
        $config['seo']=config('apps.feeship');
        $template = 'backend.feeships.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'feeships',
            'config',
            'provinces',
        ));
    }
    public function store(Request $request){
        if($request->province_id != 0 && $request->district_id !=0 && $request->ward_id !=0 && $request->cost !=0 ){
            $flag=true;
            $feeships=Feeship::all();
            foreach($feeships as $v){
                if($v->province_id == $request->province_id && $v->district_id == $request->district_id && $v->ward_id == $request->ward_id ){
                    $flag=false;
                }
            }
            if($flag==true){
                $feeship=$this->feeshipService->create($request);
                    $view=view('backend.feeships.component.data-feeship',compact('feeship'))->render();
                    return response()->json(['error' => 'false','html' => $view]);
            }else{
                return response()->json(['error' => 'false','html' => '']);
            }
        }
        return response()->json(['error' => 'true']);
    }
    public function update(Request $request){
        $get=$request->input();
        $this->feeshipService->update($get['id'], $get);
    }
    public function destroy(Request $request){
        $get=$request->input();
        if($this->feeshipService->delete($get['id'])){
            return response()->json(['error' => false]);
        }
        return response()->json(['error' => true]);
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
