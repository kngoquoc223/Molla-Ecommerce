<?php

namespace App\Repositories;

use App\Models\District;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Ward;
use App\Repositories\Interfaces\FeeshipRepositoryInterface;
use App\Repositories\BaseRepository;

class FeeshipRepository extends BaseRepository implements FeeshipRepositoryInterface
{
    protected $model;
    public function __construct(
        Feeship $model
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
            $condition['code_province']=Province::select('code')->where('name',$condition['keyword'])->first();
            $condition['code_district']=District::select('code')->where('name',$condition['keyword'])->first();
            $condition['code_ward']=Ward::select('code')->where('name',$condition['keyword'])->first();
          $query=$this->model->select($column)->where(function($query) use ($condition){
              if(isset($condition['keyword']) && !empty($condition['keyword'])){
                if(!empty($condition['code_province'])){
                    $query->where('province_id','LIKE','%'.$condition['code_province']->code.'%');
                }else if(!empty($condition['code_district'])){
                    $query->where('district_id','LIKE','%'.$condition['code_district']->code.'%');
                }else if(!empty($condition['code_ward'])){
                    $query->where('ward_id','LIKE','%'.$condition['code_ward']->code.'%');
                }
            }
            return $query;
          });
          if(!empty($join)){
              $query->join(...$join);
          }
          return $query->orderBy('created_at', 'DESC')->paginate($perpage)
                          ->withQueryString()->withPath(env('APP_URL').$extend['path']);
          }
}
