<?php

namespace App\Repositories;

use App\Models\ProductAttr;
use App\Models\User;
use App\Repositories\Interfaces\ProductAttrRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService.
 */
class ProductAttrRepository extends BaseRepository implements ProductAttrRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductAttr $model,
       
    )
    {
        $this->model=$model;
        
    }
    public function findAttrProduct($id_product){
         return $this->model->where('product_id',$id_product)->get();
    }
    public function updateWhere(string $whereField,int $id,array $payload){
        $this->model->where($whereField, $id)->update($payload);
    }
}
