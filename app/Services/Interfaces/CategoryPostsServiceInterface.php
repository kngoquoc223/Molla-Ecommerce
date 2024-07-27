<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface CategoryPostsServiceInterface
{
    public function paginate($request);
    public function create($request);

}