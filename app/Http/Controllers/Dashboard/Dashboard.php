<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Posts;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Models\Product;

class Dashboard extends Controller
{
    protected $orderService;
    protected $orderRepository;
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
    )
    {
        $this->orderService=$orderService;
        $this->orderRepository=$orderRepository;
    }
    public function index(){
        $orders=Order::count();
        $users=User::where('user_catalogue_id',2)->count();
        $products=Product::count();
        $posts=Posts::count();
        $ordersPending = Order::where('status',1)->count();
        $ordersConfirmed = Order::where('status',2)->count();
        $ordersShipping = Order::where('status',3)->count();
        $ordersDelivered = Order::where('status',4)->count();
        $ordersCancel = Order::where('status',5)->count();
        $config=$this->config();
        $template = 'backend.dashboard.home.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'ordersPending',
            'ordersConfirmed',
            'ordersShipping',
            'ordersDelivered',
            'ordersCancel',
            'orders',
            'users',
            'products',
            'posts',
        ));
    }
    private function config(){
        return [
            'js'=>[
                '/backend/js/sb-admin-2.min.js',
                '/backend/vendor/chart.js/Chart.min.js',
                '/backend/js/demo/chart-area-demo.js',
                '/backend/js/demo/chart-pie-demo.js'
            ]
            ];
    }

    
}

