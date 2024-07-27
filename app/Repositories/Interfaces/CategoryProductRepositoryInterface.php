<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface CategoryProductRepositoryInterface
{
    public function getParentCategory();
    public function getChildCategory();
    public function findParentCategory($parent_id);
    public function findChildCategory($id);
    public function pagination(
        array  $column=['*'], 
        array   $condition=[], 
        array   $join=[],
        array $extend=[],
        int  $perpage= 1,
        array $relation=[]
    );
}