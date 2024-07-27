<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckoutRequest;
use App\Models\CouponCheckout;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Models\Shipping;
use Session;
use Mail;

class CheckoutController extends Controller
{
    protected $menuRepository;
    protected $categoryProductRepository;
    protected $provinceRepository;
    public function __construct(
        ProvinceRepository $provinceRepository,
    )
    {
        $this->provinceRepository=$provinceRepository;
    }
    public function checkout(){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                'https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                '/frontend/library/location.js',
                '/frontend/library/checkout.js',
            ]
        ];
        $provinces = $this->provinceRepository->all();
        $config['title']="Molla - Trang thanh toán";
        $template = 'frontend.home.checkout';
        return view('frontend.home.layout',compact(
            'provinces',
            'template',
            'config',
        ));
    }
    public function checkoutStore(StoreCheckoutRequest $request){
        if(Session::get('cart') ==true){
            $shipping=new Shipping();
            $shipping->name=$request->name;
            $shipping->email=$request->email;
            $shipping->phone=$request->phone;
            $shipping->address=$request->address;
            $shipping->province_id=$request->province_id;
            $shipping->ward_id=$request->ward_id;
            $shipping->district_id=$request->district_id;
            $shipping->note=$request->note;
            $shipping->method_payment=$request->method_payment;
            $shipping->method_delivery=$request->method_delivery;
            $shipping->save();
            $checkout_code=substr(md5(microtime()),rand(0,26),5);
            $order= new Order();
            if(Session::get('customer') == true){
                $order->user_id=Session::get('customer')->id;
            }
            $order->order_code=$checkout_code;
            $order->shipping_id=$shipping->id;
            $order->status=1;
            if(Session::get('coupon')==true){
                foreach(Session::get('coupon') as $v){
                    $order->coupon=$v['coupon_code'];
                }
            }
            $order->save();
            foreach(Session::get('cart') as $key =>$v){
                $order_detail=new OrderDetail();
                $order_detail->order_code=$checkout_code;
                $order_detail->product_id=$v['product_id'];
                $order_detail->product_name=$v['product_name'];
                $order_detail->product_sales_qty=$v['product_qty'];
                $order_detail->product_size=$v['product_size'];
                $order_detail->product_price=$v['product_price'];
                $order_detail->save();
            }
            Session::forget('cart');
            Session::forget('coupon');
            Session::forget('cart_count');
            $data=array('email' => $shipping->email,
                        'name' => $shipping->name,
                        'phone' => $shipping->phone,
                        'address' =>$shipping->address,
                        'province' =>  $shipping->provinces->name,
                        'district' => $shipping->districts->name,
                        'ward' => $shipping->wards->name,
                        'note' => $shipping->note,
                        'method_delivery' => $shipping->method_delivery,
                        'order_code' => $order->order_code,
                        );
            $this->sendMail($data);
            toastr()->success('Thanh toán thành công.Hãy kiểm tra Email');
            return redirect()->route('home.index');
        }else{
            toastr()->error('Thanh toán không thành công. Vui lòng thử lại.'); 
            return redirect()->back();
        }
        }
    public function calculateDelivery(Request $request){
    $get=$request->input();
    if($get['delivery'] == 1){
        $get['delivery']=15000;
    }else if($get['delivery'] == 2) {
        $get['delivery']=10000;
    }else if($get['delivery'] == 3){
        $get['delivery']=30000;
    }else{
        $get['delivery']=30000;
    }
    $feeship=Feeship::where('province_id',$get['province_id'])->where('district_id',$get['district_id'])->where('ward_id',$get['ward_id'])->first();
    if(!empty($feeship)){
        return response()->json(['cost' => (int)$feeship->cost+(int)$get['delivery']]);
    }else
    {
        return response()->json(['cost' => (int)$get['delivery']]);
    }
    }
    private function config(){
        return [
            'js'=>[
            ]
            ];
    }
    private function sendMail($data){
        $to_email=$data['email'];
        Mail::send('frontend.home.mail', $data, function($message) use ($to_email){
	        $message->to($to_email)->subject('Đặt hàng thành công');
	    }); 
    }
}
