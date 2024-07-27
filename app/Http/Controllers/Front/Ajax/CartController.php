<?php

namespace App\Http\Controllers\Front\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Models\Coupon;
use RealRashid\SweetAlert\Facades\Alert;

session_start();
class CartController extends Controller
{
    protected $menuRepository;
    protected $categoryProductRepository;
    protected $provinceRepository;
    public function __construct(
        MenuRepository $menuRepository,
        CategoryProductRepository $categoryProductRepository,
    )
    {
        $this->menuRepository=$menuRepository;
        $this->categoryProductRepository=$categoryProductRepository;
    }
    public function addToCart(Request $request){
        $get=$request->input();
        $session_id=substr(md5(microtime()),rand(0,26),5);
        $cart=Session::get('cart');
        if($cart==true){
            $is_avaiable =0;
            foreach($cart as $key =>$v){
                if($v['product_id'] == $get['cart_product_id'] && $v['product_size'] == $get['cart_product_size'] ){
                    $is_avaiable ++;
                    $cart[$key] = array(
                        'session_id' => $v['session_id'],
                        'product_name' => $v['product_name'],
                        'product_id' => $v['product_id'],
                        'product_thumb' => $v['product_thumb'],
                        'product_size' => $v['product_size'],
                        'product_qty' => $v['product_qty'] + $get['cart_product_qty'],
                        'product_price' => $v['product_price'],
                        );
                        Session::put('cart',$cart);
                }
            }
            if($is_avaiable == 0){
                $cart[]=array(
                    'session_id' => $session_id,
                    'product_name' => $get['cart_product_name'],
                    'product_id' => $get['cart_product_id'],
                    'product_thumb' => $get['cart_product_thumb'],
                    'product_qty' => $get['cart_product_qty'],
                    'product_size' => $get['cart_product_size'],
                    'product_price' => $get['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
            }else
            {
            $cart[]=array(
                'session_id' => $session_id,
                'product_name' => $get['cart_product_name'],
                'product_id' => $get['cart_product_id'],
                'product_thumb' => $get['cart_product_thumb'],
                'product_qty' => $get['cart_product_qty'],
                'product_size' => $get['cart_product_size'],
                'product_price' => $get['cart_product_price'],
            );
        }
        Session::put('cart',$cart);
        Session::save();
        $reponse=$this->renderHtml(Session::get('cart'));
        return response()->json($reponse);
    }
    public function deleteToCart(Request $request){
        $get=$request->input();
        $cart=Session::get('cart');
        $total=0;
        $total_coupon=0;
        if($cart == true){
            foreach ($cart as $key =>$v){
                if($v['session_id'] == $get['session_id']){
                    unset($cart[$key]);
                }
                else{
                    $total+= $v['product_price'] * $v['product_qty'];
                }
            }
            if(isset($get['coupon'])){
                foreach($get['coupon'] as $key =>$v){
                    if($v['condition'] == 1){
                        $total_coupon+=($total*$v['value'])/100;
                    }else{
                        $total_coupon+=$v['value'];
                    }
                }
            }
        }
        Session::put('cart',$cart);
        return response()->json(['session_id' => $get['session_id'],
                                    'total'  => $total,
                                    'total_coupon' => $total_coupon,
                                    'cart_count' => $this->getCartCount(Session::get('cart')),
                                    ]);
    }
    public function updateToCart(Request $request){
        $get=$request->input();
        $cart=Session::get('cart');
        $total=0;
        $total_coupon=0;
        if($cart == true){
            foreach ($cart as $key =>$v){
                if($v['session_id'] == $get['session_id']){
                    $cart[$key]['product_qty'] = $get['qty'];
                    $total+=$v['product_price'] * $get['qty'];
                }else
                {
                    $total+= $v['product_price'] * $v['product_qty'];
                }
                
            }
            if(isset($get['coupon'])){
                foreach($get['coupon'] as $key =>$v){
                    if($v['condition'] == 1){
                        $total_coupon+=($total*$v['value'])/100;
                    }else{
                        $total_coupon+=$v['value'];
                    }
                }
            }
        }
        Session::put('cart',$cart);
        $reponse = [
            'session_id' => $get['session_id'],
            'qty' => $get['qty'],
            'price' => $get['price'],
            'total' => $total,
            'total_coupon' => $total_coupon,
            'cart_count' => $this->getCartCount(Session::get('cart')),
            ];
        return response()->json($reponse);
    }
    public function checkCoupon(Request $request){
        $coupon=Coupon::where('coupon_code',$request->coupon)->where('publish',2)->first();
        if($coupon){
            $count_coupon=$coupon->count();
            if($count_coupon > 0){
                $coupon_session=Session::get('coupon');
                if($coupon_session == true){
                    $is_avaiable= 0;
                    // foreach($coupon_session as $key => $v){
                    //     if($v['coupon_code'] == $coupon->coupon_code){
                    //         $is_avaiable++;
                    //     }
                    // }
                    if($is_avaiable == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else
                {
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                toastr()->success('Thêm mã thành công.');
                return  redirect()->back();
            }
        }
        else{
            toastr()->error('Mã giảm không đúng.Vui lòng thử lại!!'); 
            return  redirect()->back();
        }
    }
    public function deleteToCoupon(Request $request){
        $get=$request->input();
        $coupon=Session::get('coupon');
        if($coupon == true){
            foreach ($coupon as $key =>$v){
                if($v['coupon_code'] == $get['coupon_code']){
                    unset($coupon[$key]);
                }
            }
            Session::put('coupon',$coupon);
            return response()->json(['flag' => true]);
        }else
        {
            return response()->json(['flag' => false]);
        }
    }
    private function config(){
        return [
            'js'=>[
            ]
            ];
    }
    private function getCartCount($carts){
        $count=0;
        foreach($carts as $v){
            $count+=$v['product_qty'];
        }
        Session::put('cart_count',$count);
        return $count;
    }
    private function renderHtml($carts){
        $html='';
        $count=0;
        $total=0;
            foreach($carts as $v){
                $total+=$v['product_qty']*$v['product_price'];
                $count+=$v['product_qty'];
                $html.='<div id="cart-product-id-session-'.$v['session_id'].'" class="product">
                <div class="product-cart-details">
                    <h4 style="font-size: 1.5rem;" class="product-title">
                        <a style="font-family: Be VietNam" href="'.route('home.product.index',["id" => $v['product_id'],"name"=> $v['product_name']]).'">'.$v['product_name'].'</a>
                    </h4>
                    <p style="font-size: 1.3rem;">
                        <b>Size:</b> '.$v['product_size'].'
                    </p>
                    <span class="cart-product-info">
                        <span style="background: #f7f7f7;color: #252a2b" class="cart-product-qty">'.$v['product_qty'].'</span>
                        x <b>'.number_format($v['product_price'], 0, ',', '.').'đ</b>
                    </span>
                </div><!-- End .product-cart-details -->
    
                <figure style="max-width: 90px;margin: revert" class="product-image-container">
                    <a href="'.route('home.product.index',["id" => $v['product_id'],"name"=> $v['product_name']]).'" class="product-image">
                        <img src="/storage/'.$v['product_thumb'].'" alt="product">
                    </a>
                </figure>
                <button data-session_id='.$v['session_id'].' class="btn-remove remove-cart" title="Remove Product"><i class="icon-close"></i></button>
            </div><!-- End .product -->';
            }
            $html.='<div class="dropdown-cart-total">
                            <span style="font-size: 1.4rem">Tổng tiền:</span>
                            <span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">'.number_format($total, 0, ',', '.').'đ</span>
                        </div>
                         <div style="justify-content: center" class="dropdown-cart-action">
                            <a href="'.route('cart.index').'" class="btn btn-primary">XEM GIỎ HÀNG</a>
                        </div><!-- End .dropdown-cart-total -->
                        ';
        Session::put('cart_count',$count);
        $reponse=['html' => $html,'cart_count' => $count];
        return $reponse;
    }
}
