<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface CouponServiceInterface
{
    public function paginate($request);
    public function create($request);

}