<?php

namespace App\Services;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use App\Services\Interfaces\AttributeValueServiceInterface;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class AttributeValueService.
 */
class AttributeValueService implements AttributeValueServiceInterface
{
    protected $attributeValueRepository;
    public function __construct(
        AttributeValueRepository $attributeValueRepository,
        )
    {
        $this->attributeValueRepository=$attributeValueRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $attributeValues=$this->attributeValueRepository->findById($post['modelId']);
            if($payload[$post['field']]==2){
                if($attributeValues->attribute_catalogue->publish != 2){
                    Attribute::where('id',$attributeValues->attribute_catalogue->id)->update($payload);
                }
            }
            $this->attributeValueRepository->update($post['modelId'], $payload);
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
            $attributeValues=$this->attributeValueRepository->findById($post['id'][0]);
            if($payload[$post['field']]==2){
                if($attributeValues->attribute_catalogue->publish != 2){
                    Attribute::where('id',$attributeValues->attribute_catalogue->id)->update($payload);
                }
            }
            $flag=$this->attributeValueRepository->updateByWhereIn('id',$post['id'],$payload);
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
        $condition['id_attribute']=$request->integer('id_attribute');
        $perPage=$request->integer('perpage');
        $attributes=$this->attributeValueRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/attribute/index']
            , $perPage
        );
        return $attributes;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $attributeValues=$this->attributeValueRepository->create($payload);
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
            $attributeValues=$this->attributeValueRepository->update($id, $payload);
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
            $attributeValues=$this->attributeValueRepository->forceDelete($id);
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
                'id_attribute',
                'value',
                'publish',
            ];
    }
}
