<?php

namespace App\Services;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use App\Services\Interfaces\AttributeServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class AttributeService.
 */
class AttributeService implements AttributeServiceInterface
{
    protected $attributeRepository;
    protected $attributeValueRepository;
    public function __construct(
        AttributeValueRepository $attributeValueRepository,
        AttributeRepository $attributeRepository,
        )
    {
        $this->attributeValueRepository=$attributeValueRepository;
        $this->attributeRepository=$attributeRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $attribute=$this->attributeRepository->update($post['modelId'], $payload);
            $this->changeAttrValueStatus($post, $payload[$post['field']]);
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
            $flag=$this->attributeRepository->updateByWhereIn('id',$post['id'],$payload);
            $this->changeAttrValueStatus($post,$post['value']);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function changeAttrValueStatus($post,$value){
        DB::beginTransaction();
        try{
            $array=[];
            if(isset($post['modelId'])){
                $array[] = $post['modelId'];
            }else{
                $array = $post['id'];
            }
            $payload[$post['field']]= $value;
            $this->attributeValueRepository->updateByWhereIn('id_attribute', $array, $payload);
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
        $perPage=$request->integer('perpage');
        $attributes=$this->attributeRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/attribute/catalogue/index']
            , $perPage
        );
        return $attributes;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $attribute=$this->attributeRepository->create($payload);
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
            $attribute=$this->attributeRepository->update($id, $payload);
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
            $attribute=$this->attributeRepository->forceDelete($id);
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
                'publish',
            ];
    }
}
