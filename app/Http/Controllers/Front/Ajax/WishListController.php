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
class WishListController extends Controller
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
    public function addToWishList(Request $request){
        $get=$request->input();
        $session_id=substr(md5(microtime()),rand(0,26),5);
        $wishlist=Session::get('wishlist');
        $is_avaiable=0;
        if($wishlist==true){
            foreach($wishlist as $key =>$v){
                if($v['product_id'] == $get['wishlist_product_id']){
                    $is_avaiable ++;
                }
            }
            if($is_avaiable==0){
                $wishlist[]=array(
                    'session_id' => $session_id,
                    'product_name' => $get['wishlist_product_name'],
                    'product_id' => $get['wishlist_product_id'],
                    'product_thumb' => $get['wishlist_product_thumb'],
                    'product_price' => $get['wishlist_product_price'],
                );
                Session::put('wishlist',$wishlist);
            }
        }else{
            $wishlist[]=array(
                'session_id' => $session_id,
                'product_name' => $get['wishlist_product_name'],
                'product_id' => $get['wishlist_product_id'],
                'product_thumb' => $get['wishlist_product_thumb'],
                'product_price' => $get['wishlist_product_price'],
            );
            Session::put('wishlist',$wishlist);
        }
        Session::save();
        $reponse=$this->renderHtml(Session::get('wishlist'),$is_avaiable);
        return response()->json($reponse);
    }
    public function removeToWishList(Request $request){
        $get=$request->input();
        $wishlist=Session::get('wishlist');
        if($wishlist == true){
            foreach ($wishlist as $key =>$v){
                if($v['session_id'] == $get['session_id']){
                    unset($wishlist[$key]);
                }
            }
        }
        Session::put('wishlist',$wishlist);
        return response()->json(['session_id' => $get['session_id'],
                                'wishlist_count' => $this->getWishlistCount(Session::get('wishlist')),
                                ]);
    }
    public function removeToWishListAll(){
        Session::forget('wishlist');
        Session::forget('wishlist_count');
        return response()->json(['flag'=>true]);
    }
    private function getWishlistCount($carts){
        $count=count($carts);
        Session::put('wishlist_count',$count);
        return $count;
    }
    private function renderHtml($carts,$is_avaiable){
        $html='';
        $count=count($carts);
            foreach($carts as $item){
                $html.='<div id="wishlist-product-id-session-'.$item['session_id'].'" style="display: inline-flex;" class="compare-product">
                            <a href="'.route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']]).'">
                                <img style="max-width: 90px;margin: revert" src="/storage/'.$item['product_thumb'].'" alt="product">
                            </a>
                            <div style="display: inline-flex;">
                                <h4 style="font-size: 1.5rem;" class="product-title">
                                    <a style="font-family: Be VietNam" href="'.route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']]).'">'.$item['product_name'].'</a>
                                </h4>
                                    <b style="color: #666">'.number_format($item['product_price'], 0, ',', '.').'đ</b>
                            </div>
                            <button data-session_id='.$item['session_id'].' class="btn-remove remove-wishlist" title="Remove Product"><i class="icon-close"></i></button>
                        </div>';
            }
        Session::put('wishlist_count',$count);
        $reponse=['html' => $html,'wishlist_count' => $count,'flag'=>$is_avaiable];
        return $reponse;
    }
}
