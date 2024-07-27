<?php

namespace App\Repositories;

use App\Models\ProductImage;
use App\Models\User;
use App\Repositories\Interfaces\ProductImageRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService.
 */
class ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductImage $model,
       
    )
    {
        $this->model=$model;
        
    }
}
