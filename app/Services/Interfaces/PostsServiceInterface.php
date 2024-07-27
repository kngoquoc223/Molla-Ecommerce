<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface PostsServiceInterface
{
    public function paginate($request);
    public function create($request);

}