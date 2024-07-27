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
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\Product;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository

    )
    {
        $this->orderService=$orderService;
        $this->orderRepository=$orderRepository;
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
        $orders = $this->orderService->paginate($request);
        $config['seo']=config('apps.order');
        $template = 'backend.orders.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'orders',
            'config',
        ));
    }
    public function detailIndex($code){
        $order=Order::where('order_code',$code)->first();
        $coupon=Coupon::where('coupon_code',$order->coupon)->first();
        $order_details=OrderDetail::where('order_code',$code)->get();
        $shipping=Shipping::where('id',$order->shipping_id)->first();
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
        $config['seo']=config('apps.orderDetail');
        $template = 'backend.orders.detail';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'order',
            'order_details',
            'shipping',
            'coupon'
        ));
    }
    public function updateStatus(Request $request){
        $get=$request->input();
        $flag=true;
        if($get['status']==2){
            $order_details=OrderDetail::select('product_id','product_sales_qty','product_size')->where('order_code',$get['order_code'])->get();
            foreach($order_details as $v){
               $product=Product::where('id',$v->product_id)->first();
               if(!empty($product)){
                foreach($product->attr as $value){
                    if($value->value==$v->product_size){
                        if($v->product_sales_qty > $value->pivot->quantity){
                            $flag=false;
                        }
                    }
                }
                }
            }
            if($flag==true){
                if($this->orderService->update($get['order_id'],$get)){
                    foreach($order_details as $v){
                        $product=Product::where('id',$v->product_id)->first();
                        if(!empty($product)){
                            foreach($product->attr as $value){
                                if($value->value==$v->product_size){
                                    $product->quantity=$product->quantity-$v->product_sales_qty;
                                    $value->pivot->quantity=$value->pivot->quantity-$v->product_sales_qty;
                                    $value->pivot->save();
                                }
                            }
                            $product->save();
                        }
                    }
                    return response()->json(['flag' => true]);
                }else{
                    return response()->json(['flag' => false]);
                }
            }else{
                return response()->json(['flag' => false]);
            }
        }
        else if($get['status']==5){
            $order_details=OrderDetail::select('product_id','product_sales_qty','product_size')->where('order_code',$get['order_code'])->get();
            foreach($order_details as $v){
               $product=Product::where('id',$v->product_id)->first();
               if(!empty($product)){
                foreach($product->attr as $value){
                    if($value->value==$v->product_size){
                        $product->quantity=$product->quantity+$v->product_sales_qty;
                        $value->pivot->quantity=$value->pivot->quantity+$v->product_sales_qty;
                        $value->pivot->save();
                    }
                }
                $product->save();
            }
            }
        }
        if($this->orderService->update($get['order_id'],$get)){
            return response()->json(['flag' => true]);
        }else
        {
            return response()->json(['flag' => false]);
        }
    }
    public function destroy(Request $request){
        $get=$request->input();
        DB::beginTransaction();
        try{
            Order::where('order_code',$get['order_code'])->forceDelete();
            OrderDetail::where('order_code',$get['order_code'])->forceDelete();
            Shipping::where('id',$get['shipping_id'])->forceDelete();
            DB::commit();
            return response()->json(['flag' => true]);
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return response()->json(['flag' => false]);
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
