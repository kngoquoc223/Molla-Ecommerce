<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Models\User;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService.
 */
class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryInterface
{
    protected $model;

    public function __construct(
        AttributeValue $model,
       
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
                  $query->where('value','LIKE','%'.$condition['keyword'].'%');
              }
                if(isset($condition['publish']) && $condition['publish'] != 0){
                $query->where('publish','=',$condition['publish']);
                }
                if(isset($condition['id_attribute']) && $condition['id_attribute'] != 0){
                    $query->where('id_attribute','=',$condition['id_attribute']);
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
