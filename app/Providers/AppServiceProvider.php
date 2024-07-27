<?php

namespace App\Providers;

use App\Models\CategoryProduct;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public $serviceBindings=[
        'App\Services\Interfaces\UserServiceInterface'=>'App\Services\UserService',
        'App\Repositories\Interfaces\UserRepositoryInterface'=>'App\Repositories\UserRepository',
        'App\Services\Interfaces\PostsServiceInterface'=>'App\Services\PostsService',
        'App\Repositories\Interfaces\PostsRepositoryInterface'=>'App\Repositories\PostsRepository',
        'App\Services\Interfaces\CategoryPostsServiceInterface'=>'App\Services\CategoryPostsService',
        'App\Repositories\Interfaces\CategoryPostsRepositoryInterface'=>'App\Repositories\CategoryPostsRepository',
        'App\Services\Interfaces\OrderServiceInterface'=>'App\Services\OrderService',
        'App\Repositories\Interfaces\OrderRepositoryInterface'=>'App\Repositories\OrderRepository',
        'App\Services\Interfaces\FeeshipServiceInterface'=>'App\Services\FeeshipService',
        'App\Repositories\Interfaces\FeeshipRepositoryInterface'=>'App\Repositories\FeeshipRepository',
        'App\Services\Interfaces\CouponServiceInterface'=>'App\Services\CouponService',
        'App\Repositories\Interfaces\CouponRepositoryInterface'=>'App\Repositories\CouponRepository',
        'App\Repositories\Interfaces\ProductImageRepositoryInterface'=>'App\Repositories\ProductImageRepository',
        'App\Services\Interfaces\MenuServiceInterface'=>'App\Services\MenuService',
        'App\Repositories\Interfaces\MenuRepositoryInterface'=>'App\Repositories\MenuRepository',
        'App\Services\Interfaces\AttributeValueServiceInterface'=>'App\Services\AttributeValueService',
        'App\Repositories\Interfaces\AttributeValueRepositoryInterface'=>'App\Repositories\AttributeValueRepository',
        'App\Services\Interfaces\ProductAttrServiceInterface'=>'App\Services\ProductAttrService',
        'App\Repositories\Interfaces\ProductAttrRepositoryInterface'=>'App\Repositories\ProductAttrRepository',
        'App\Services\Interfaces\AttributeServiceInterface'=>'App\Services\AttributeService',
        'App\Repositories\Interfaces\AttributeRepositoryInterface'=>'App\Repositories\AttributeRepository',
        'App\Services\Interfaces\SliderServiceInterface'=>'App\Services\SliderService',
        'App\Repositories\Interfaces\SliderRepositoryInterface'=>'App\Repositories\SliderRepository',
        'App\Services\Interfaces\ProductServiceInterface'=>'App\Services\ProductService',
        'App\Repositories\Interfaces\ProductRepositoryInterface'=>'App\Repositories\ProductRepository',
        'App\Services\Interfaces\CategoryProductServiceInterface'=>'App\Services\CategoryProductService',
        'App\Repositories\Interfaces\CategoryProductRepositoryInterface'=>'App\Repositories\CategoryProductRepository',
        'App\Services\Interfaces\UserCatalogueServiceInterface'=>'App\Services\UserCatalogueService',
        'App\Repositories\Interfaces\UserCatalogueRepositoryInterface'=>'App\Repositories\UserCatalogueRepository',
        'App\Repositories\Interfaces\ProvinceRepositoryInterface'=>'App\Repositories\ProvinceRepository',
        'App\Repositories\Interfaces\DistrictRepositoryInterface'=>'App\Repositories\DistrictRepository',
    ];
    public function register(): void
    {
        //
        foreach($this->serviceBindings as $key =>$val){
            $this->app->bind($key,$val);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
