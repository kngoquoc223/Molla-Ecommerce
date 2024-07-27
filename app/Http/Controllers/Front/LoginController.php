<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Models\CategoryProduct as ModelsCategoryProduct;
use Illuminate\Support\Carbon;
use App\Models\Shipping;
use Session;
use App\Models\Menu;
use App\Models\CategoryPosts;

class LoginController extends Controller
{
    protected $menuRepository;
    protected $categoryProductRepository;
    protected $userRepository;
    protected $provinceRepository;
    public function __construct(
        UserRepository $userRepository,
        ProvinceRepository $provinceRepository,
        MenuRepository $menuRepository,
        CategoryProductRepository $categoryProductRepository,
    )
    {
        $this->userRepository=$userRepository;
        $this->provinceRepository=$provinceRepository;
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
                'https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                'https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
            ]
        ];
        $config['title']="Molla - Đăng nhập / Đăng ký";
        $template = 'frontend.home.login';
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function login(Request $request){
        $data = User::where('email',$request->email)->where('publish',2)->first();
        if($data != ''){
            if(Hash::check($request->password,$data->password)){
                Session::put('customer',$data);
                toastr()->success('Đăng nhập thành công.');
                return redirect()->route('home.index');
            }
        }
        toastr()->error('Email hoặc Mật khẩu không chính xác.');       
        return back();

    }
    public function logout(Request $request){
        Session::forget('customer');
        return redirect()->route('home.index');
    }
    public function myUser(){
        $config=$this->config();
        $config=[
            'css'=> [
                '/frontend/assets/css/customize.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                'https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js',
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                '/frontend/library/user.js',
                '/frontend/library/home.js',
            ]
        ];
        $provinces = $this->provinceRepository->all();
        $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
        $menus=Menu::where('publish',2)->get();
        $category_posts=CategoryPosts::where('publish',2)->get();
        $orders = DB::table('orders')
        ->where('orders.user_id',Session::get('customer')->id)
        ->join('shippings', 'orders.shipping_id', '=', 'shippings.id')
        ->orderBy('orders.created_at','desc')
        ->get();
        $config['title']="Molla - Thông tin người dùng";
        $template = 'frontend.home.user';
        return view('frontend.home.layout',compact(
            'template',
            'config',
            'provinces',
            'orders',
            'category_products',
            'menus',
            'category_posts',
        ));
    }
    public function updateUser(Request $request){
        $get=$request->input();
            if($get['birthday']!=null){
                $get['birthday']=$this->convertBirthdayDate($get['birthday']);
            }
            DB::beginTransaction();
            try{
                $user=$this->userRepository->update($get['id'], $get);
                DB::commit();
                $data = User::where('id',$get['id'])->first();
                Session::put('customer',$data);
                return response()->json(['flag' => true]);
            } catch(\Exception $e){
                DB::rollBack();
                echo $e->getMessage();die();
                return response()->json(['flag' => false]);
            }
    }
    public function changeEmail(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng. Ví dụ abc@gmail.com.',
            'email.unique' => 'Email đã tồn tại.',
            'email.string' => 'Email phải là dạng ký tự.',
            'email.max' => 'Độ dài email tối đa 191 ký tự.',
        ];
        $validatedData = Validator::make($request->all(),[
            'email'=>'required|string|email|unique:users|max:191',
        ],$messages);
        if ($validatedData->fails()) {
            return response()->json(['flag' => false ,'error' => $validatedData->errors() ]);
        }else{
            $get=$request->input();
            DB::beginTransaction();
            try{
                $user=$this->userRepository->update($get['id'], $get);
                DB::commit();
                $data = User::where('id',$get['id'])->first();
                Session::put('customer',$data);
                return response()->json(['flag' => true]);
            } catch(\Exception $e){
                DB::rollBack();
                echo $e->getMessage();die();
                return response()->json(['flag' => false]);
            }
        }
        
    }
    public function changePassword(Request $request){
            $get=$request->input();
            $data = User::where('id',$get['id'])->first();
            if(Hash::check($get['password_old'],$data->password)){
                $get['password']=Hash::make($get['password']);
                DB::beginTransaction();
                try{
                    $user=$this->userRepository->update($get['id'], $get);
                    DB::commit();
                    Session::put('customer',$data);
                    return response()->json(['flag' => true]);
                } catch(\Exception $e){
                    DB::rollBack();
                    echo $e->getMessage();die();
                    return response()->json(['flag' => false]);
                }
            }
            return response()->json(['flag' => false,'error' => 'Mật khẩu không đúng.Vui lòng kiểm tra lại']);
    }
    public function register(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng. Ví dụ abc@gmail.com.',
            'email.unique' => 'Email đã tồn tại.',
            'email.string' => 'Email phải là dạng ký tự.',
            'email.max' => 'Độ dài email tối đa 191 ký tự.',
            'name.required' => 'Vui lòng nhập Họ Tên.',
            'name.string' => 'Họ tên phải là dạng ký tự.',
            'name.min' => 'Họ tên phải lớn hơn 8 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là dạng ký tự.',
            'password.min' => 'Mật khẩu phải lớn hơn 6 ký tự.',
            're_password.required' => 'Vui lòng nhập vào ô. Nhập lại mật khẩu.',
            're_password.same' => 'Mật khẩu không trùng khớp.',
        ];
        $validatedData = Validator::make($request->all(),[
            'email'=>'required|string|email|unique:users|max:191',
            'name'=>'required|string|min:8',
            'password'=>'required|string|min:6',
            're_password'=>'required|string|same:password',
        ],$messages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }else{
            try{
                $user=User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'publish' => 2,
                ]);
                Session::put('customer',$user);
                toastr()->success('Đăng ký tài khoản thành công.');
                return redirect()->route('home.index');
                // toastr()->success('Đăng ký thành công.Hãy đăng nhập tài khoản');
                // return redirect()->route('home.user.showForm');
                DB::commit();
                return true;
            } catch(\Exception $e){
                DB::rollBack();
                echo $e->getMessage();die();
                return false;
            }
        }
    }
    private function convertBirthdayDate($birthday = ''){
        $carbonDate=Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday=$carbonDate->format('Y-m-d H:i:s');
        return $birthday;
    }
    private function config(){
        return [
            'js'=>[
                '/frontend/library/home.js',
            ]
            ];
    }
}
