<?php

namespace App\Services;

use App\Models\ProductImage;
use App\Services\Interfaces\UploadServiceInterface;
use App\Repositories\Interfaces\ProductImageRepositoryInterface as ProductImageRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UploadService.
 */
class UploadService implements UploadServiceInterface
{
        protected $productImageRepository;
        protected $productRepository;
        public function __construct(
                ProductRepository $productRepository,
                ProductImageRepository $productImageRepository,
        )
        {
                $this->productRepository=$productRepository;
                $this->productImageRepository=$productImageRepository;
        }
    public function store($request){
        if ($request->hasFile('file')){
        try {
                $name=$request->file('file')->getClientOriginalName();
                $pathFull='uploads/'.$request->location.'/'.date('Y/m/d');
                $path=$request->file('file')->storeAs('public/'.$pathFull,$name);
                // $path=$request->file('file')->move(public_path('/storage/'.$pathFull), $name);
                return $pathFull.'/'.$name;
                // '/storage/'.$pathFull.'/' . $name;
        } catch (\Exception $error) {
                return false;
        }
    }
    }
    public function delete($id){
        DB::beginTransaction();
        try{
            $product_images=ProductImage::where('product_id',$id)->get();
            if(!$product_images->isEmpty()){
                foreach($product_images as $v){
                        ProductImage::where('id',$v->id)->forceDelete();
                        Storage::disk('public')->delete($v->image);
                    }
            }
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function update($id, $request){
        DB::beginTransaction();
        try{
                if($request->hasFile('images')){
                        $payload['product_images']['product_id']=$id;
                        $product=$this->productRepository->findById($id);
                        if(!$product->images->isEmpty()){
                            foreach ($product->images as $v){
                                Storage::disk('public')->delete($v->image);
                                $this->productImageRepository->forceDelete($v->id);
                            }
                        }
                        foreach($request->images as $key => $v){
                             $name=$v->getClientOriginalName();
                             $pathFull='uploads/products/'.date('Y/m/d');
                             $path=$v->storeAs('public/'.$pathFull,$name);
                             $payload['product_images']['image']= $pathFull.'/' . $name;
                             $this->productImageRepository->create($payload['product_images']);
                        }
                        DB::commit();
                        return true;
                }
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
}
