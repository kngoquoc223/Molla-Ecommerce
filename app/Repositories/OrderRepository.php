<?php

namespace App\Repositories;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $model;
    public function __construct(
        Order $model
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
                    $query->where('order_code','LIKE','%'.$condition['keyword'].'%');
                }
                if(isset($condition['order_status']) && $condition['order_status'] != 0){
                    $query->where('status','=',$condition['order_status']);
                }
            return $query;
          });
          if(!empty($join)){
              $query->join(...$join);
          }
          return $query->orderBy('created_at')->paginate($perpage)
                          ->withQueryString()->withPath(env('APP_URL').$extend['path']);
          }
}
