<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface FeeshipServiceInterface
{
    public function paginate($request);
    public function create($request);

}