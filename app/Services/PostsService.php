<?php

namespace App\Services;
use App\Services\Interfaces\PostsServiceInterface;
use App\Repositories\Interfaces\PostsRepositoryInterface as PostsRepository;
use App\Repositories\Interfaces\CategoryPostsRepositoryInterface as CategoryPostsRepository;
use App\Models\PostsComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\CategoryPosts;
/**
 * Class UserService.
 */
class PostsService implements PostsServiceInterface
{
    protected $postsRepository;
    protected $categoryPostsRepository;
    public function __construct(
        CategoryPostsRepository $categoryPostsRepository,
        PostsRepository $postsRepository,
        )
    {
        $this->categoryPostsRepository=$categoryPostsRepository;
        $this->postsRepository=$postsRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $posts=$this->postsRepository->findById($post['modelId']);
            if($payload[$post['field']]==2){
                if($posts->category->publish != 2){
                    CategoryPosts::where('id',$posts->category->id)->update($payload);
                }
            }
            $posts=$this->postsRepository->update($post['modelId'], $payload);
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
                    $posts=$this->postsRepository->findById($v);
                    if($posts->category->publish != 2){
                        CategoryPosts::where('id',$posts->category->id)->update($payload);
                    }
                }
            }
            $flag=$this->postsRepository->updateByWhereIn('id',$post['id'],$payload);
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
        $condition['publish']=$request->integer('publish');
        $condition['posts_catologue_id']=$request->integer('posts_catologue_id');
        $perPage=$request->integer('perpage');
        $posts=$this->postsRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/posts/index']
            , $perPage
        );
        return $posts;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['slug']= Str::slug($request->input('title','-'));
            $posts=$this->postsRepository->create($payload);
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
            $payload['slug']= Str::slug($request->input('title','-'));
            $posts=$this->postsRepository->update($id, $payload);
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
            $posts=$this->postsRepository->findById($id);
            if($posts->comment != null){
                foreach($posts->comment as $v){
                    if($v->parent_id == 0){
                        foreach($v->child as $value){
                            PostsComment::where('id', $value->id)->forceDelete();
                        }
                    }
                    PostsComment::where('id', $v->id)->forceDelete();
                }
            }
            $posts->forceDelete($id);
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
                'category_id',
                'title',
                'desc',
                'content',
                'meta_desc',
                'meta_keywords',
                'image',
                'publish',
                'user_id',
                'slug',
            ];
    }

}
