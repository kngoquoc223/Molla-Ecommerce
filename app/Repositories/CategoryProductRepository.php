<?php

namespace App\Repositories;

use App\Models\CategoryProduct;
use App\Models\User;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService.
 */
class CategoryProductRepository extends BaseRepository implements CategoryProductRepositoryInterface
{
    protected $model;
    public function __construct(CategoryProduct $model)
    {
        $this->model=$model;
    }
    public function getParentCategory(){
        return $this->model->where('parent_id',0)->get();
    }
    public function getChildCategory(){
        return $this->model->where('parent_id','!=',0)->get();
    }
    public function findParentCategory($parent_id){
        return $this->model->where('id',$parent_id)->first();
    }
    public function findChildCategory($id){
        return $this->model->where('parent_id',$id)->get();
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
                  $query->where('name','LIKE','%'.$condition['keyword'].'%');
              }
                if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish','=',$condition['publish']);
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
