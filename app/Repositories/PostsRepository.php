<?php

namespace App\Repositories;
use App\Models\Posts;
use App\Repositories\Interfaces\PostsRepositoryInterface;
use App\Repositories\BaseRepository;

class PostsRepository extends BaseRepository implements PostsRepositoryInterface
{
    protected $model;
    public function __construct(
        Posts $model
    ){
        $this->model=$model;
    }
    public function pagination(
        array  $column=['*'], 
        array   $condition=[], 
        array   $join=[],
        array $extend=[],
        int  $perpage= 1,
        array $relation=[]
      ){
          $query=$this->model->select($column)->where(function($query) use ($condition){
                if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish','=',$condition['publish']);
                }
                if(isset($condition['posts_catologue_id']) && $condition['posts_catologue_id'] != 0){
                    $query->where('category_id','=',$condition['posts_catologue_id']);
                    }
            return $query;
          });
          if(!empty($join)){
              $query->join(...$join);
          }
          return $query->orderBy('created_at','desc')->paginate($perpage)
                          ->withQueryString()->withPath(env('APP_URL').$extend['path']);
          }
}
