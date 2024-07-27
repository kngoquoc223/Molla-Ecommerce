<?php

namespace App\Services;
use App\Services\Interfaces\MenuServiceInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class MenuService implements MenuServiceInterface
{
    protected $menuRepository;
    public function __construct(
        MenuRepository $menuRepository,
        )
    {
        $this->menuRepository=$menuRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $menu=$this->menuRepository->update($post['modelId'], $payload);
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
            $flag=$this->menuRepository->updateByWhereIn('id',$post['id'],$payload);
          //  $this->changeUserStatus($post,$post['value']);
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
        $menus=$this->menuRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/interface/menu/index']
            , $perPage
        );
        return $menus;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['slug']= Str::slug($request->input('name','-'));
            $menu=$this->menuRepository->create($payload);
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
            $menu=$this->menuRepository->update($id, $payload);
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
            $menu=$this->menuRepository->forceDelete($id);
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
                'slug',
                'updated_at',
                'publish',
            ];
    }

}
