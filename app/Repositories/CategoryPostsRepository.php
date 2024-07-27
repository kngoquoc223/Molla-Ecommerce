<?php

namespace App\Repositories;
use App\Models\CategoryPosts;
use App\Repositories\Interfaces\CategoryPostsRepositoryInterface;
use App\Repositories\BaseRepository;

class CategoryPostsRepository extends BaseRepository implements CategoryPostsRepositoryInterface
{
    protected $model;
    public function __construct(
        CategoryPosts $model
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
              if(isset($condition['keyword']) && !empty($condition['keyword'])){
                  $query->where('coupon_name','LIKE','%'.$condition['keyword'].'%')
                  ->orWhere('coupon_code','LIKE','%'.$condition['keyword'].'%');
                }
                if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish','=',$condition['publish']);
                }
                if(isset($condition['condition']) && $condition['condition'] != 0){
                    $query->where('coupon_condition','=',$condition['condition']);
                    }
            return $query;
          });
          if(!empty($join)){
              $query->join(...$join);
          }
          return $query->paginate($perpage)
                          ->withQueryString()->withPath(env('APP_URL').$extend['path']);
          }
}
