<?php

namespace App\Repositories;
use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use App\Repositories\BaseRepository;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{
    protected $model;
    public function __construct(
        Slider $model
    ){
        $this->model=$model;
    }
    
}
