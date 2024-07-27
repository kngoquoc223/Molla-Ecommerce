<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService.
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(
        Product $model,
       
    )
    {
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
                  $query->where('name','LIKE','%'.$condition['keyword'].'%');
              }
                if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish','=',$condition['publish']);
                }
                if(isset($condition['product_catologue']) && $condition['product_catologue'] != 0){
                    $query->where('category_id','=',$condition['product_catologue'])
                         ->orWhere('parent_category_id','=',$condition['product_catologue']);
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
