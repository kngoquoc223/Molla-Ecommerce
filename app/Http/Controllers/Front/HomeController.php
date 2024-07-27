<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\CategoryProduct;
use App\Models\AttributeValue;
use App\Models\CategoryPosts;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\SliderRepositoryInterface as  SliderRepository;
use App\Models\CategoryProduct as ModelsCategoryProduct;
use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Menu;
use App\Models\Posts;
use App\Models\PostsComment;
use App\Models\Product;
use App\Models\Slider;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use Illuminate\Support\Facades\Request as RequestSeg;
use Illuminate\Http\Request as Request;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    protected $menuRepository;
    protected $categoryProductRepository;
    protected $sliderRepository;
    protected $productRepository;
    protected $attributeValueRepository;
    public function __construct(
        ProductRepository $productRepository,
        SliderRepository $sliderRepository,
        MenuRepository $menuRepository,
        CategoryProductRepository $categoryProductRepository,
        AttributeValueRepository $attributeValueRepository,
    )
    {
        $this->attributeValueRepository=$attributeValueRepository;
        $this->productRepository=$productRepository;
        $this->sliderRepository=$sliderRepository;
        $this->menuRepository=$menuRepository;
        $this->categoryProductRepository=$categoryProductRepository;
    }
    public function index(){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $menus=Menu::where('publish',2)->get();
        $sliders=Slider::where('publish',2)->get();
        $newArrivalsProducts=Product::latest()->where('publish',2)->take(10)->get();
        $productSales=Product::where('discount','!=','')->where('publish',2)->latest()->take(10)->get();
        $topSalling = DB::table('order_details')
        ->leftJoin('products','products.id','=','order_details.product_id')
        ->select('products.id',
        DB::raw('SUM(order_details.product_sales_qty) as total'))
        ->groupBy('products.id')
        ->orderBy('total','desc')
        ->limit(10)
        ->get();
        $array['id']=[];
        foreach($topSalling as $v){
                $array['id'][]=$v->id;
        }
        $posts=Posts::where('publish',2)->take(8)->get();
        $tempStr = implode(',', array_filter($array['id']));
        $tempStr==''?$tempStr='0':$tempStr;
        $productMostSellings=Product::whereIn('id',$array['id'])->where('publish',2)->orderBy(DB::raw("FIELD(id, $tempStr)"))->get();
        // $productMostSellings=Product::whereIn('id',$array['id'])->where('publish',2)->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $coupons=Coupon::where('publish',2)->get();
        $config['title']="Molla - Trang bán hàng trực tuyến";
        $template = 'frontend.home.index';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'menus',
            'category_products',
            'sliders',
            'newArrivalsProducts',
            'productSales',
            'productMostSellings',
            'posts',
            'category_posts',
            'coupons',
        ));
    }
    public function category(Request $request){
        // if(!empty($request->input())){
        //     $get=$request->input();
        //     $products=$this->filterCategory($get);
        //         $total = $products->total();
        //         $currentPage = $products->currentPage();
        //         $perPage = $products->perPage();
        //         $to = min($currentPage * $perPage, $total);
        //         $htmlProduct="{$to} of {$total}";
        //         $view = View::make('frontend.category.component.data',compact('products'))->render();
        //         // $view = view('frontend.category.component.data',compact('products'))->render();
        //         $reponse=[
        //             'flag' => true,
        //             'html' =>$view,
        //             'countProduct' => $htmlProduct,
        //         ];
        //         return response()->json($reponse);
        // }
        $slug=RequestSeg::segment(count(RequestSeg::segments()));
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/home.js',
                '/frontend/library/category.js',
            ]
        ];
        $categoryProducts=ModelsCategoryProduct::where('slug',$slug)->where('publish',2)->first();
        if(!$categoryProducts->child->isEmpty())
        {
            $sub_array=array();
            foreach($categoryProducts->child as $v){
                if($v->publish==2){
                    $sub_array[]=$v->id;
                }
            }
            $products=Product::whereIn('category_id',$sub_array)->where('publish',2)->orderBy('created_at','desc')->get();
        }else{
            $products=Product::where('category_id',$categoryProducts->id)->where('publish',2)->orderBy('created_at','desc')->get();
        }
        $product_attrs=AttributeValue::orderBy('created_at','desc')->get();
        // $product_attrs=$this->attributeValueRepository->all();
        
        //nav
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - ".$categoryProducts->description;
        $template = 'frontend.category.index';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'products',
            'categoryProducts',
            'category_products',
            'menus',
            'product_attrs',
            'category_posts',
        ));
    }
    public function product($id){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                '/frontend/library/product.js',
            ]
        ];
        $product=$this->productRepository->findById($id);
        $products=Product::where('category_id',$product->category_id)->orderBy('created_at','desc')->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $comments=Comment::where('product_id',$id)->where('parent_id',0)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - ".$product->name;
        $template = 'frontend.product.index';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'product',
            'category_products',
            'menus',
            'comments',
            'products',
            'category_posts',
        ));
    }
    public function cart(){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                '/frontend/library/cart.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $coupons=Coupon::where('publish',2)->get();
        $config['title']="Molla - Giỏ hàng";
        $template = 'frontend.home.cart';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'category_products',
            'menus',
            'category_posts',
            'coupons',
        ));
    }
    //ajax
    public function newArrival(Request $request){
        $get=$request->input();
        if($get['catId'] == 'all'){
            $newArrivalsProducts=Product::latest()->where('publish',2)->paginate(10);
            $view= view('frontend.home.pages.new-arrival',compact('newArrivalsProducts'))->render();
            return response()->json(['html' => $view]);
        }
        $newArrivalsProducts=Product::where('parent_category_id',$get['catId'])->latest()->where('publish',2)->paginate(10);
        $view= view('frontend.home.pages.new-arrival',compact('newArrivalsProducts'))->render();
        return response()->json(['html' => $view]);
    }
    public function topSelling(Request $request){
        $get=$request->input();
        $topSalling = DB::table('order_details')
        ->leftJoin('products','products.id','=','order_details.product_id')
        ->select('products.id',
        DB::raw('SUM(order_details.product_sales_qty) as total'))
        ->where(function($topSalling) use ($get){
            if($get['catId']!='all'){
                $topSalling->where('products.parent_category_id',$get['catId']);
            }
            return $topSalling;
        })
        ->groupBy('products.id')
        ->orderBy('total','desc')
        ->limit(10)
        ->get();
        $array['id']=[];
        foreach($topSalling as $v){
                $array['id'][]=$v->id;
        }
        $tempStr = implode(',', array_filter($array['id']));
        $tempStr==''?$tempStr='0':$tempStr;
        $productMostSellings=Product::whereIn('id',$array['id'])->where('publish',2)->orderBy(DB::raw("FIELD(id, $tempStr)"))->get();
        $view= view('frontend.home.pages.top-selling',compact('productMostSellings'))->render();
        return response()->json(['html' => $view]);
    }
    public function loadQuickView(Request $request){
        $get=$request->input();
        $product=Product::where('id',$get['product_id'])->first();
        if(!empty($product)){
            $output['product_gallery']='';
            $output['product_slide']='';
            foreach($product->images as $key => $v){
                $output['product_gallery'].='
                <a type="button" class="carousel-dot '.($key==0?'active':'').'">
                <img src="/storage/'.$v->image.'">
                </a>
                ';
                $output['product_slide'].='
                <div class="intro-slide" data-hash="'.$key.'">
                    <img src="/storage/'.$v->image.'" alt="Image Desc">
                                </div><!-- End .intro-slide -->
                ';
            }
            $output['product_thumb']='<img id="product-zoom" src="/storage/'.$product->thumb.'"  alt="product image">';
            $output['product_name']=$product->name;
            $output['product_id']=$product->id;
            $output['product_content']=$product->content;
            if($product->discount != ''){
                $output['product_price']='
                <span class="new-price">'.number_format($product->discount, 0, ',', '.').'đ </span>
                <span class="old-price">'.number_format($product->price, 0, ',', '.').'đ </span>
                <input type="hidden" class="cart_product_price_'.$product->id.'" value="'.$product->discount.'">
                ';
            }
            else{
                $output['product_price']='
                 '.number_format($product->price, 0, ',', '.').'đ
                <input type="hidden" class="cart_product_price_'.$product->id.'" value="'.$product->price.'">
                ';
            }
            $output['product_size']='';
            foreach($product->attr as $key => $v){
                $output['product_size'].='<a href="#" onClick="return false;" value="'.$v->value.'" data-quantity="'.$v->pivot->quantity.'" data-value="'.$v->id.'" class="item-size '.($v->pivot->quantity==0 ? 'disabled' : '').'" title="'.$v->value.'">'.$v->value.'</a>';
            }
            $output['product_size'].='<input type="hidden" class="cart_product_size_active">';
            $output['input_hidden']='
            <input type="hidden" class="cart_product_id_'.$product->id.'" value="'.$product->id.'">
            <input type="hidden" class="cart_product_name_'.$product->id.'" value="'.$product->name.'">
            <input type="hidden" class="cart_product_thumb_'.$product->id.'" value="'.$product->thumb.'">
            ';
            $output['btn_cart']='<a href="#" onClick="return false;" data-id_product="'.$product->id.'" style="font-family: Be VietNam" class="btn-product btn-cart"><span>Thêm Giỏ Hàng</span></a>';
            $output['btn_wishlist']='<a href="#" onClick="return false;" data-id_product="'.$product->id.'" style="font-family: Be VietNam" class="btn-product btn-wishlist btn-wishlist-quickview" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>';
            $count=0;
            $rating=0;
            foreach ($product->comment as $v) {
                if($v->parent_id == 0){
                    $count++;
                    $rating+=$v->rating;
                }
            }
            if($rating != 0 && $count !=0){
                $rating_val=$rating/$count;
            }else{
                $rating_val=0;
            }
            $output['review_link']='('.$count.' Đánh giá)';
            $output['ratings_val']=$rating_val*20;
            return response()->json(['flag'=>true,'output'=>$output]);
        }else{
            return response()->json(['flag'=>false]);
        }
    }
    public function comment(Request $request){
        $get=$request->input();
        DB::beginTransaction();
        try{
            $comment=new Comment();
            $comment->comment=$get['comment'];
            $comment->user_id=$get['user_id'];
            $comment->user_name=$get['user_name'];
            $comment->product_id=$get['product_id'];
            $comment->parent_id=0;
            $comment->publish=1;
            $comment->rating=$get['rating'];
            $comment->save();
            DB::commit();
            return response()->json(['flag' => true]);
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return response()->json(['flag' => false]);
        }
    }
    public function replyComment(Request $request){
        $get=$request->input();
        DB::beginTransaction();
        try{
            $comment=new Comment();
            $comment->comment=$get['comment'];
            $comment->user_id=$get['user_id'];
            $comment->user_name=$get['user_name'];
            $comment->product_id=$get['product_id'];
            $comment->parent_id=$get['parent_id'];
            $comment->publish=1;
            $comment->save();
            DB::commit();
            return response()->json(['flag' => true]);
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return response()->json(['flag' => false]);
        }
    }
    public function removeComment(Request $request){
        $get=$request->input();
        if($get['id']!=''){
            DB::beginTransaction();
            try{
                $comment=Comment::where('id', $get['id'])->first();
                if($comment->parent_id == 0){
                    foreach($comment->child as $v){
                        Comment::where('id', $v->id)->forceDelete();
                    }
                }
                Comment::where('id', $get['id'])->forceDelete();
                DB::commit();
                return response()->json(['flag' => true]);
            } catch(\Exception $e){
                DB::rollBack();
                echo $e->getMessage();die();
                return response()->json(['flag' => false]);
            }
        }
        return response()->json(['flag' => false]);
    }
    public function posts(){
        $config=$this->config();
        $posts=Posts::where('publish',2)->orderBy('created_at','desc')->paginate(6);
        $new_posts=Posts::where('publish',2)->orderBy('created_at','desc')->take(4)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $menus=Menu::where('publish',2)->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $config['title']="Molla - Bài Viết";
        $template = 'frontend.posts.index';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'menus',
            'category_products',
            'posts',
            'category_posts',
            'new_posts',
        ));
    }
    public function singlePosts($slug){
        $posts=Posts::where('slug',$slug)->first();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $comments=PostsComment::where('posts_id',$posts->id)->where('parent_id',0)->get();
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                '/frontend/library/home.js',
                '/frontend/library/posts.js',
            ]
        ];
        $menus=Menu::where('publish',2)->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $config['title']="Molla - ".$posts->title;
        $template = 'frontend.posts.single';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'menus',
            'category_products',
            'posts',
            'category_posts',
            'comments',
        ));
    }
    public function categoryPosts($slug){
        $config=$this->config();
        $category=CategoryPosts::where('publish',2)->where('slug',$slug)->first();
        $posts=Posts::where('publish',2)->where('category_id',$category->id)->orderBy('created_at','desc')->paginate(6);
        $new_posts=Posts::where('publish',2)->where('category_id',$category->id)->orderBy('created_at','desc')->take(4)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $menus=Menu::where('publish',2)->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $config['title']="Molla - ".$category->name;
        $template = 'frontend.posts.index';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'menus',
            'category_products',
            'posts',
            'category_posts',
            'new_posts',
        ));
    }
    public function posts_comment(Request $request){
        $get=$request->input();
        DB::beginTransaction();
        try{
            $comment=new PostsComment();
            $comment->comment=$get['comment'];
            $comment->user_id=$get['user_id'];
            $comment->user_name=$get['user_name'];
            $comment->posts_id=$get['posts_id'];
            $comment->parent_id=0;
            $comment->publish=1;
            $comment->save();
            DB::commit();
            return response()->json(['flag' => true]);
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return response()->json(['flag' => false]);
        }
    }
    public function posts_replyComment(Request $request){
        $get=$request->input();
        DB::beginTransaction();
        try{
            $comment=new PostsComment();
            $comment->comment=$get['comment'];
            $comment->user_id=$get['user_id'];
            $comment->user_name=$get['user_name'];
            $comment->posts_id=$get['posts_id'];
            $comment->parent_id=$get['parent_id'];
            $comment->publish=1;
            $comment->save();
            DB::commit();
            return response()->json(['flag' => true]);
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return response()->json(['flag' => false]);
        }
    }
    public function posts_removeComment(Request $request){
        $get=$request->input();
        if($get['id']!=''){
            DB::beginTransaction();
            try{
                $comment=PostsComment::where('id', $get['id'])->first();
                if($comment->parent_id == 0){
                    foreach($comment->child as $v){
                        PostsComment::where('id', $v->id)->forceDelete();
                    }
                }
                PostsComment::where('id', $get['id'])->forceDelete();
                DB::commit();
                return response()->json(['flag' => true]);
            } catch(\Exception $e){
                DB::rollBack();
                echo $e->getMessage();die();
                return response()->json(['flag' => false]);
            }
        }
        return response()->json(['flag' => false]);
    }
    public function contact(){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                '/frontend/library/home.js',
                '/frontend/library/contact.js',
            ]
        ];
        $menus=Menu::where('publish',2)->get();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - Liên hệ";
        $template = 'frontend.home.contact';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'menus',
            'category_products',
            'category_posts',
        ));
    }
    public function search(Request $request){
        $condition['keywords']=addslashes($request->input('keywords'));
        $condition['publish']=$request->integer('publish');
        $query=Product::where(function($query) use ($condition){
            if(isset($condition['keywords']) && !empty($condition['keywords'])){
                $query->where('name','LIKE','%'.$condition['keywords'].'%');
              }
              if(isset($condition['publish']) && $condition['publish'] != 0){
              $query->where('publish','=',$condition['publish']);
              }
            return $query;
        });
        $products=$query->orderBy('created_at','desc')->get();
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $config['title']="Molla - Kết quả tìm kiếm";
        $template = 'frontend.home.search';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'products',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function new_arrival(){
        $products=Product::latest()->where('publish',2)->paginate(18);
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $config['title']="Molla - Sản phẩm mới phát hành";
        $template = 'frontend.category.component.new-arrival';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'products',
            'category_products',
            'menus',
        ));
    }
    public function top_selling(){
        $topSalling = DB::table('order_details')
        ->leftJoin('products','products.id','=','order_details.product_id')
        ->select('products.id',
             DB::raw('SUM(order_details.product_sales_qty) as total'))
        ->groupBy('products.id')
        ->orderBy('total','desc')
        ->limit(42)
        ->get();
        $array['id']=[];
        foreach($topSalling as $v){
                $array['id'][]=$v->id;
        }
        $tempStr = implode(',', array_filter($array['id']));
        $tempStr==''?$tempStr='0':$tempStr;
        $products=Product::whereIn('id',$array['id'])->where('publish',2)->orderBy(DB::raw("FIELD(id, $tempStr)"))->get();
        // $products=Product::whereIn('id',$array['id'])->where('publish',2)->get();
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - Sản phẩm bán chạy";
        $template = 'frontend.category.component.top-selling';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'products',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function flash_sale(){
        $products=Product::where('discount','!=','')->where('publish',2)->latest()->get();
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/home.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - Sản phẩm khuyến mãi";
        $template = 'frontend.category.component.flash-sale';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'products',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function showFormCheckOrder(){
        $config=$this->config();
        $config=[
            'css'=> [
                '',
            ],
            'js' => [
                '/frontend/library/checkOrder.js',
                '/frontend/library/home.js',
            ]
        ];
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $config['title']="Molla - Kiểm tra đơn hàng";
        $template = 'frontend.home.checkOrder';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function checkOrder(Request $request){
        $get=$request->input();
        $orders = DB::table('orders')
        ->where('orders.order_code',$get['order_code'])
        ->join('shippings', 'orders.shipping_id', '=', 'shippings.id')
        ->orderBy('orders.created_at','desc')
        ->first();
        if($orders != null){
            $view = View::make('frontend.home.component.data-order',compact('orders'))->render();
            return response()->json(['flag' => true,'html' => $view]);
        }else{
            return response()->json(['flag' => false]);
        }
    }
    public function autocomplete(Request $request){
        $get=$request->input();
        if($get['query']){
            $products= Product::where('publish',2)->where('name','LIKE','%'.$get['query'].'%')->take(6)->get();
            $output='<ul class="dropdown-menu" style="overflow: auto;width: 570px;">';
            foreach($products as $v){
                $output.='
                <li style="display: inline-flex;" class="compare-product">
                            <a href="'.route('home.product.index',["id" => $v->id,"name" => $v->name]).'">
                                <img style="max-width: 90px;margin: revert" src="/storage/'.$v->thumb.'" alt="product">
                            </a>
                            <div style="display: inline-flex;padding-left: 15px;">
                                <h4 style="font-size: 1.5rem;" class="product-title">
                                    <a style="font-family: Be VietNam" href="'.route('home.product.index',["id" => $v->id,"name" => $v->name]).'">'.$v->name.'</a>
                                </h4>
                            </div>
                    </li>
                ';
            }
            $output.='</ul>';
            echo $output;
        }
    }
    private function config(){
        return [
            'js'=>[
                '/frontend/library/home.js',
            ]
            ];
    }
}
