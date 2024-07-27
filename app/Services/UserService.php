<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\PostsComment;
use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;
use App\Models\UserCatalogue;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    protected $userReponsitory;
    public function __construct(
        UserRepository $userReponsitory)
    {
        $this->userReponsitory=$userReponsitory;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $users=$this->userReponsitory->findById($post['modelId']);
            if($payload[$post['field']]==2){
                if($users->user_catalogues->publish != 2){
                    UserCatalogue::where('id',$users->user_catalogues->id)->update($payload);
                }
            }
            $user=$this->userReponsitory->update($post['modelId'], $payload);
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
            if($payload[$post['field']]==2){
                foreach($post['id'] as $v){
                    $users=$this->userReponsitory->findById($v);
                if($users->user_catalogues->publish != 2){
                    UserCatalogue::where('id',$users->user_catalogues->id)->update($payload);
                }
            }
            }
            $flag=$this->userReponsitory->updateByWhereIn('id',$post['id'],$payload);
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
        $condition['user_catologue_id']=$request->integer('user_catologue_id');
        $perPage=$request->integer('perpage');
        $users=$this->userReponsitory->pagination($this->paginateSelect(), $condition, [], ['path' => '/admin/user/index'], $perPage);
        
        return $users;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','re_password']);
            if($payload['birthday']!=null){
                $payload['birthday']=$this->convertBirthdayDate($payload['birthday']);
            }
            $payload['password']=Hash::make($payload['password']);
            $payload['publish']=2;
            $user=$this->userReponsitory->create($payload);
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
            $payload=$request->except(['_token']);
            if(isset($payload['birthday'])){
                if($payload['birthday']!=null){
                    $payload['birthday']=$this->convertBirthdayDate($payload['birthday']);
                }
            }
            $user=$this->userReponsitory->update($id, $payload);
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
            $user=$this->userReponsitory->findById($id);
            if($user->comment_posts != null){
                foreach($user->comment_posts as $v){
                    if($v->parent_id == 0){
                        foreach($v->child as $value){
                            PostsComment::where('id', $value->id)->forceDelete();
                        }
                    }
                    PostsComment::where('id', $v->id)->forceDelete();
                }
            }
            if($user->comment_product != null){
                foreach($user->comment_product as $v){
                    if($v->parent_id == 0){
                        foreach($v->child as $value){
                            Comment::where('id', $value->id)->forceDelete();
                        }
                    }
                    Comment::where('id', $v->id)->forceDelete();
                }
            }
            $user=$this->userReponsitory->forceDelete($id);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function convertBirthdayDate($birthday = ''){
        $carbonDate=Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday=$carbonDate->format('Y-m-d H:i:s');
        return $birthday;
    }
    private function paginateSelect(){
            return [
                'id',
                'email',
                'phone',
                'address',
                'name',
                'publish',
                'user_catalogue_id'
            ];
    }

}
