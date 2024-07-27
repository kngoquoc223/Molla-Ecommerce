<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\User;
use App\Repositories\Interfaces\AttributeRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService.
 */
class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
    protected $model;

    public function __construct(
        Attribute $model,
       
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
            return $query;
          });
          if(!empty($join)){
              $query->join(...$join);
          }
          return $query->paginate($perpage)
                          ->withQueryString()->withPath(env('APP_URL').$extend['path']);
          }

}
