<?php

namespace App\Services;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Services\Interfaces\CategoryProductServiceInterface;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Services\ProductService as ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class CategoryProductService.
 */
class CategoryProductService implements CategoryProductServiceInterface
{
    protected $categoryProductRepository;
    protected $productRepository;
    protected $ProductService;
    public function __construct(
        ProductService $ProductService,
        CategoryProductRepository $categoryProductRepository,
        ProductRepository $productRepository,
        )
    {
        $this->ProductService= $ProductService;
        $this->productRepository=$productRepository;
        $this->categoryProductRepository=$categoryProductRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $category=CategoryProduct::where('id',$post['modelId'])->first();
            if($category->parent_id != 0){
                if($payload[$post['field']]==2){
                    if($category->parent->publish != 2){
                        $this->categoryProductRepository->update($category->parent->id, $payload);
                    }
                }
                Product::where('category_id',$post['modelId'])->update($payload);
            }
            else{
                Product::where('parent_category_id',$category->id)->update($payload);
            }
            $category=$this->categoryProductRepository->update($post['modelId'], $payload);
            $this->changeCategoryProductStatus($post, $payload[$post['field']]);
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
            $flag=$this->categoryProductRepository->updateByWhereIn('id',$post['id'],$payload);
            $this->changeCategoryProductStatus($post,$post['value']);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function changeCategoryProductStatus($post,$value){
        DB::beginTransaction();
        try{
            $array=[];
            if(isset($post['modelId'])){
                $array[] = $post['modelId'];
            }else{
                $array = $post['id'];
            }
            $payload[$post['field']]= $value;
            $this->categoryProductRepository->updateByWhereIn('parent_id', $array, $payload);
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
        $perPage=$request->integer('perpage')==0?40:$request->integer('perpage');
        $categoryProducts=$this->categoryProductRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/product/category/index']
            , $perPage,['category_products']
        );
        return $categoryProducts;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['slug']= Str::slug($request->input('name','-'));
            $category=$this->categoryProductRepository->create($payload);
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
            $payload['slug']= Str::slug($request->input('name','-'));
            $this->categoryProductRepository->update($id, $payload);
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
            $category=$this->categoryProductRepository->findById($id);
            if($category->parent_id==0){
                if($category->child != null){
                    foreach ($category->child as $v){
                        $product=Product::where('category_id',$v->id)->first();
                        if(!empty($product)){
                            $this->ProductService->delete($product->id);
                        }
                        $this->categoryProductRepository->forceDelete($v->id);
                    }
                    $this->categoryProductRepository->forceDelete($id);
                }
            }else{
                $product=Product::where('category_id',$id)->first();
                if(!empty($product)){
                    $this->ProductService->delete($product->id);
                }
                $this->categoryProductRepository->forceDelete($id);
            }
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
                'parent_id',
                'description',
                'slug',
                'publish',
                'banner',
                'updated_at',
            ];
    }

}
