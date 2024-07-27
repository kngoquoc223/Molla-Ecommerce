<?php

namespace App\Services;
use App\Services\Interfaces\ProductAttrServiceInterface;
use App\Repositories\Interfaces\ProductAttrRepositoryInterface as ProductAttrRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class ProductAttrService.
 */
class ProductAttrService implements ProductAttrServiceInterface
{
    protected $productAttrRepository;
    public function __construct(
        ProductAttrRepository $productAttrRepository,
        )
    {
        $this->productAttrRepository=$productAttrRepository;
    }
    public function paginate($request)
    {
        $condition['keyword']=addslashes($request->input('keyword'));
        $condition['publish']=$request->integer('publish');
        $perPage=$request->integer('perpage');
        $productattrs=$this->productAttrRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/productAttr/index']
            , $perPage
        );
        return $productattrs;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $productAttr=$this->productAttrRepository->create($payload);
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
            $productAttr=$this->productAttrRepository->update($id, $payload);
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
            $productAttr=$this->productAttrRepository->forceDelete($id);
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
                'product_id',
                'attr_value_id',
            ];
    }
}
