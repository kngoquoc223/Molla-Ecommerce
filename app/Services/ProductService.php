<?php

namespace App\Services;

use App\Http\Controllers\Dashboard\CategoryProduct;
use App\Models\CategoryProduct as ModelsCategoryProduct;
use App\Models\ProductAttr;
use App\Models\ProductImage;
use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\ProductAttrRepositoryInterface as ProductAttrRepository;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use App\Repositories\Interfaces\ProductImageRepositoryInterface as ProductImageRepository;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class ProductService.
 */
class ProductService implements ProductServiceInterface
{
    protected $productRepository;
    protected $categoryProductRepository;
    protected $productAttrRepository;
    protected $attributeValueRepository;
    protected $productImageRepository;
    public function __construct(
        ProductImageRepository $productImageRepository,
        ProductRepository $productRepository,
        CategoryProductRepository $categoryProductRepository,
        ProductAttrRepository $productAttrRepository,
        AttributeValueRepository $attributeValueRepository,
        
        )
    {
        $this->productImageRepository=$productImageRepository;
        $this->attributeValueRepository=$attributeValueRepository;
        $this->productAttrRepository=$productAttrRepository;
        $this->categoryProductRepository=$categoryProductRepository;
        $this->productRepository=$productRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $product=$this->productRepository->findById($post['modelId']);
            if($payload[$post['field']]==2){
                $updatePayload=[];
                $updatePayload[$post['field']]=(($post['value']==1)?2:1);
                if($product->category_products->publish != 2){
                    ModelsCategoryProduct::where('id',$product->category_id)->update($updatePayload);
                    if($product->category_products->parent->publish != 2){
                        ModelsCategoryProduct::where('id',$product->category_products->parent->id)->update($updatePayload);
                    }
                }
            }
            $product=$this->productRepository->update($post['modelId'], $payload);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function updateStatusAll($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = $post['value'];
            foreach($post['id'] as $v){
                $product=$this->productRepository->findById($v);
                if($payload[$post['field']]==2){
                    $updatePayload=[];
                    $updatePayload[$post['field']]=$post['value'];
                    if($product->category_products->publish != 2){
                        ModelsCategoryProduct::where('id',$product->category_id)->update($updatePayload);
                        if($product->category_products->parent->publish != 2){
                            ModelsCategoryProduct::where('id',$product->category_products->parent->id)->update($updatePayload);
                        }
                    }
                }
            }
            $flag=$this->productRepository->updateByWhereIn('id',$post['id'],$payload);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function paginate($request)
    {
        $condition['keyword']=addslashes($request->input('keyword'));
        $condition['publish']=$request->integer('publish');
        $condition['product_catologue']=$request->integer('product_catologue_id');
        $perPage=$request->integer('perpage')==0?40:$request->integer('perpage');
        $products=$this->productRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/product/index']
            , $perPage
        );
        return $products;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send','images']);
            $payload['price']=filter_var($payload['price'],FILTER_SANITIZE_NUMBER_INT);
            $payload['discount']=filter_var($payload['discount'],FILTER_SANITIZE_NUMBER_INT);
            $payload['slug']= Str::slug($request->input('name','-'));
            $payload['parent_category_id']=$request->catParent;
            $product=$this->productRepository->create($payload);
            $sync_data = [];
            for($i=0; $i<count($payload['attr']);$i++){
                $sync_data[$payload['attr'][$i]['attr_value_id']] = ['quantity' => $payload['attr'][$i]['quantity']];
            }
            $product->attr()->attach($sync_data);
            if($request->hasFile('images')){
                $payload['product_images']['product_id']=$product->id;
                foreach($request->images as $key => $v){
                     $name=$v->getClientOriginalName();
                     $pathFull='uploads/products/'.date('Y/m/d');
                     $path=$v->storeAs('public/'.$pathFull,$name);
                     $payload['product_images']['image']= $pathFull.'/' . $name;
                     $this->productImageRepository->create($payload['product_images']);
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
            $payload=$request->except(['_token','send']);
            $payload['price']=filter_var($payload['price'],FILTER_SANITIZE_NUMBER_INT);
            $payload['discount']=filter_var($payload['discount'],FILTER_SANITIZE_NUMBER_INT);
            $payload['parent_category_id']=$request->catParent;
            $product=$this->productRepository->update($id, $payload);
            $product=$this->productRepository->findById($id);
            $sync_data = [];
            for($i=0; $i<count($payload['attr']);$i++){
                $sync_data[$payload['attr'][$i]['attr_value_id']] = ['quantity' => $payload['attr'][$i]['quantity']];
            }
            $product->attr()->sync($sync_data);
            if($request->hasFile('images')){
                $payload['product_images']['product_id']=$product->id;
                foreach($request->images as $key => $v){
                     $name=$v->getClientOriginalName();
                     $pathFull='uploads/products/'.date('Y/m/d');
                     $path=$v->storeAs('public/'.$pathFull,$name);
                     $payload['product_images']['images']['image'] = $pathFull.'/' . $name;
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
    public function delete($id){
        DB::beginTransaction();
        try{
            $product=$this->productRepository->findById($id);
            $product->attr()->detach();
            if(!$product->images->isEmpty()){
                foreach ($product->images as $v){
                    Storage::disk('public')->delete($v->image);
                    $this->productImageRepository->forceDelete($v->id);
                }
            }
            if($product->comment != null){
                foreach($product->comment as $v){
                    if($v->parent_id == 0){
                        foreach($v->child as $value){
                            Comment::where('id', $value->id)->forceDelete();
                        }
                    }
                    Comment::where('id', $v->id)->forceDelete();
                }
            }
            $product->forceDelete($id);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function paginateSelect(){
            return [
                'id',
                'name',
                'description',
                'content',
                'category_id',
                'price',
                'img',
                'publish',
                'discount',
                'thumb',
                'parent_category_id',
                'quantity',
            ];
    }

}
