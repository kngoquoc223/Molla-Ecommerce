<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */

interface ProductAttrRepositoryInterface
{
    public function updateWhere(string $whereField,int $id,array $payload);
    public function findAttrProduct($id_product);
}