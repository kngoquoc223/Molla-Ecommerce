<?php

namespace App\Services;
use App\Services\Interfaces\CategoryPostsServiceInterface;
use App\Repositories\Interfaces\CategoryPostsRepositoryInterface as CategoryPostsRepository;
use App\Services\PostsService as PostsService;
use App\Repositories\Interfaces\PostsRepositoryInterface as PostsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class CategoryPostsService implements CategoryPostsServiceInterface
{
    protected $categoryPostsRepository;
    protected $postsService;
    protected $postsRepository;
    public function __construct(
        PostsRepository $postsRepository,
        PostsService $postsService,
        CategoryPostsRepository $categoryPostsRepository,
        )
    {
        $this->postsRepository=$postsRepository;
        $this->postsService=$postsService;
        $this->categoryPostsRepository=$categoryPostsRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $categoryPosts=$this->categoryPostsRepository->update($post['modelId'], $payload);
            $this->changePostsStatus($post, $payload[$post['field']]);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function changePostsStatus($post,$value){
        DB::beginTransaction();
        try{
            $array=[];
            if(isset($post['modelId'])){
                $array[] = $post['modelId'];
            }else{
                $array = $post['id'];
            }
            $payload[$post['field']]= $value;
            $this->postsRepository->updateByWhereIn('category_id', $array, $payload);
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
            $flag=$this->categoryPostsRepository->updateByWhereIn('id',$post['id'],$payload);
            $this->changePostsStatus($post, $payload[$post['field']]);
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
        $condition['condition']=$request->integer('condition');
        $perPage=$request->integer('perpage');
        $categoryPosts=$this->categoryPostsRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/posts/category/index']
            , $perPage
        );
        return $categoryPosts;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['slug']= Str::slug($request->input('name','-'));
            $categoryPosts=$this->categoryPostsRepository->create($payload);
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
            $categoryPosts=$this->categoryPostsRepository->update($id, $payload);
            $post=[];
            $post['field']="publish";
            $post['modelId']=$id;
            $payload[$post['field']] = $request['publish'];
            $this->changePostsStatus($post, $payload[$post['field']]);
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
            $categoryPosts=$this->categoryPostsRepository->findById($id);
            if($categoryPosts->posts != null){
                foreach($categoryPosts->posts as $v){
                    $this->postsService->delete($v->id);
                }
            }
            $categoryPosts->forceDelete($id);
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
                'slug',
                'updated_at',
            ];
    }

}
