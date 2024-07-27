<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use App\Repositories\Interfaces\ProductImageRepositoryInterface as ProductImageRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;


class UploadController extends Controller
{
        protected $uploadService;
        protected $productImageRepository;
        protected $productRepository;
        public function __construct(
            ProductRepository $productRepository,
            ProductImageRepository $productImageRepository,
            UploadService $uploadService
            )
        {
            $this->productRepository=$productRepository;
            $this->productImageRepository=$productImageRepository;
            $this->uploadService = $uploadService;
        }
        public function editImage($id){
        $config=[
                'css'=> [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                    '/backend/css/customize.css'
                ],
                'js' => [
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                    '/backend/library/library.js',
                ]
            ];
           $product=Product::where('id',$id)->first();
           $productImages=ProductImage::where('product_id',$id)->get();
           $template='backend.products.product.component.image';
           return view('backend.dashboard.layout',compact(
            'template',
            'productImages',
            'config',
            'product',
           ));
        }
        public function updateImage($id, Request $request){
            if($this->uploadService->update($id, $request)){
                toastr()->success('Cập nhật bản ghi thành công.');
                return redirect()->route('product.index');
            }
            toastr()->error('Cập nhật bản ghi không thành công. Vui lòng thử lại.'); 
            return redirect()->route('product.index');
        }
        public function destroyImage(Request $request){
            $get=$request->input();
            if($this->uploadService->delete($get['id'])){
                return response()->json(['flag' => true]);
            }
            return response()->json(['flag' => false]);
        }
        public function store(Request $request){
           $url= $this->uploadService->store($request);
           if($url != false){
            return response()->json([
                'error' => false,
                'url' => $url
            ]);
           }
           return response()->json([
            'error' => true
        ]);
        }
}
