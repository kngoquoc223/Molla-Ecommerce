<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface UserCatalogueServiceInterface
{
    public function paginate($request);
    public function create($request);

}