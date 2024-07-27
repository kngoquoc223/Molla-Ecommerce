<?php

namespace App\Http\Controllers\Front\Ajax;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\View;
use App\Models\Coupon;
use App\Models\ProductAttr;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
    public function filterCategory(Request $request){
        $get=$request->input();
        if(isset($get['cat'])){
                $query=Product::where(function($query) use ($get){
                    if(isset($get['price'])){
                        if(isset($get['price']['price_max'])){
                            $query->where('products.price','>=', (int)$get['price']['price_min'])->where('products.price','<=',(int)$get['price']['price_max']);
                        }else{
                            $query->where('products.price','>=',(int)$get['price']['price_min']);
                        }
                    }
                    $query->whereIn('products.category_id',$get['cat']);
                    $query->where('products.publish',2);
                    return $query;
                });
                if(isset($get['attr_value_id'])){
                    $query->join('product_attr',function($query) use ($get){
                        $query->on('product_attr.product_id','=','products.id');
                        if(isset($get['attr_value_id'])){
                            $query->whereIn('product_attr.attr_value_id',$get['attr_value_id']);
                            $query->where('product_attr.quantity','>',0);
                        }
                        return $query;
                    });
                }
            if(isset($get['order_by']))
            switch($get['order_by'])
            {
                case'desc':
                    $query->orderBy('products.name','DESC');
                    break;
                case'asc':
                    $query->orderBy('products.name','ASC');
                    break;
                case'new':
                    $query->orderBy('products.created_at','DESC');
                    break;
                case'old':
                    $query->orderBy('products.created_at','ASC');
                    break;
                case'price_max':
                    $query->orderByRaw('CAST(products.price AS UNSIGNED) ASC');
                    break;
                case'price_min':
                    $query->orderByRaw('CAST(products.price AS UNSIGNED) DESC');
                    break;
            }
            $products=$query->get();
            if(!empty($products)){
                if(isset($get['attr_value_id'])){
                    $array=[];
                    foreach($products as $key => $v){
                        if($key==0){
                            $array['product'][]=$v['product_id'];
                        }else{
                            if(in_array($v['product_id'],$array['product'])){
                                $products->forget($key);
                            }else{
                                $array['product'][]=$v['product_id'];
                            }
                        }
                    }
                }
                $view = View::make('frontend.category.component.data',compact('products'))->render();
                return Response::json(['flag' => true,'html'=>$view]);
            }else{
                return Response::json(['flag' => false]);
            }
        }else{
            return Response::json(['flag' => false]);
        }
    }
}
