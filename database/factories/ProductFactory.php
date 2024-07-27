<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>'Giày Thể Thao Nam Bitis',
            'category_id'=>24,
            'publish'=>2,
            'thumb'=>'uploads/thumb/products/2024/05/30/hsw005800xam__2__9c53325536e2425c8bd7d47eb36ed027_1024x1024.webp',
            'parent_category_id'=>22,
            'quantity'=>1,
        ];
    }
}
