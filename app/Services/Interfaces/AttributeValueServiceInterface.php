<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface AttributeValueServiceInterface
{
    public function create($request);
    public function paginate($request);

}