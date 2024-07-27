<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface FeeshipRepositoryInterface
{
    public function pagination(
        array  $column=['*'], 
        array   $condition=[], 
        array   $join=[],
        array $extend=[],
        int  $perpage= 1,
        array $relation=[]
    );
}