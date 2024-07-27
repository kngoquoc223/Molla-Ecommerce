<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserCatalogueServiceInterface;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\UserService as UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
/**
 * Class UserService.
 */
class UserCatalogueService implements UserCatalogueServiceInterface
{
    protected $userCatalogueRepository;
    protected $userRepository;
    protected $userService;
    public function __construct(
        UserService $userService,
        UserCatalogueRepository $userCatalogueRepository,
        UserRepository $userRepository,
        )
    {
        $this->userService=$userService;
        $this->userCatalogueRepository=$userCatalogueRepository;
        $this->userRepository=$userRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $user=$this->userCatalogueRepository->update($post['modelId'], $payload);
            $this->changeUserStatus($post, $payload[$post['field']]);
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
            $flag=$this->userCatalogueRepository->updateByWhereIn('id',$post['id'],$payload);
            $this->changeUserStatus($post,$post['value']);
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
            $this->userRepository->updateByWhereIn('user_catalogue_id', $array, $payload);
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
        $userCatalogues=$this->userCatalogueRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => 'user/catalogue/index']
            , $perPage,['users']
        );
        return $userCatalogues;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['publish']=2;
            $user=$this->userCatalogueRepository->create($payload);
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
            $user=$this->userCatalogueRepository->update($id, $payload);
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
            $user=$this->userCatalogueRepository->findById($id);
            if($user->users != null){
                foreach($user->users as $v){
                    $this->userService->delete($v->id);
                }
            }
            $user=$this->userCatalogueRepository->delete($id);
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
            ];
    }

}
