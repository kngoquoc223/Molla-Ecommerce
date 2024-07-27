<?php

namespace App\Services;
use App\Services\Interfaces\SliderServiceInterface;
use App\Repositories\Interfaces\SliderRepositoryInterface as SliderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
/**
 * Class UserService.
 */
class SliderService implements SliderServiceInterface
{
    protected $sliderRepository;
    public function __construct(
        SliderRepository $sliderRepository,
        )
    {
        $this->sliderRepository=$sliderRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $slider=$this->sliderRepository->update($post['modelId'], $payload);
         //   $this->changeUserStatus($post, $payload[$post['field']]);
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
            $flag=$this->sliderRepository->updateByWhereIn('id',$post['id'],$payload);
          //  $this->changeUserStatus($post,$post['value']);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function changeUserStatus($post,$value){
        DB::beginTransaction();
        try{
            $array=[];
            if(isset($post['modelId'])){
                $array[] = $post['modelId'];
            }else{
                $array = $post['id'];
            }
            $payload[$post['field']]= $value;
            $this->sliderRepository->updateByWhereIn('user_catalogue_id', $array, $payload);
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
        $sliders=$this->sliderRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/interface/slider/index']
            , $perPage
        );
        return $sliders;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $slider=$this->sliderRepository->create($payload);
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
            $slider=$this->sliderRepository->update($id, $payload);
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
            $slider=$this->sliderRepository->forceDelete($id);
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
                'description',
                'thumb',
                'url',
            ];
    }

}
