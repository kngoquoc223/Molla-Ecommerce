<?php

use App\Http\Controllers\Ajax\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Middleware\AuthCheck;
use App\Http\Controllers\Dashboard\UserController;

use App\Http\Middleware\AlreadyLoggedIn;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Dashboard\UserCatalogueController;
use App\Http\Controllers\Dashboard\CategoryProduct;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UploadController;
use App\Http\Controllers\Ajax\getCategoryProductController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Front\Ajax\getProductController;
use App\Http\Controllers\Dashboard\Controller;
use App\Http\Controllers\Dashboard\AttributeValueController;
use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Front\Ajax\HomeGetProductController;
use App\Http\Controllers\Front\Ajax\LoadProductMoreController;
use App\Http\Controllers\Front\HomeProductController;
use App\Http\Controllers\Front\Ajax\CartController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\FeeshipController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Front\Ajax\CategoryController;
use App\Http\Controllers\Front\Ajax\WishListController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\MailController;
use App\Http\Middleware\UserCheck;
use App\Http\Middleware\AlreadyLoggedInUser;
use App\Http\Controllers\Dashboard\CategoryPostsController;
use App\Http\Controllers\Dashboard\PostsController;
use App\Models\Coupon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Auth admin


Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('show-from-login')->middleware(AlreadyLoggedIn::class);
    Route::get('register', [AuthController::class, 'showFormRegister'])->name('show-from-register')->middleware(AlreadyLoggedIn::class);
    Route::post('register', [AuthController::class, 'register'])->name('register')->middleware(AlreadyLoggedIn::class);
    Route::post('login', [AuthController::class, 'login'])->name('login')->middleware(AlreadyLoggedIn::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard/index', [Dashboard::class, 'index'])->name('show-dashboard')->middleware(AuthCheck::class);

    Route::group(['prefix' => 'user/catalogue'], function () {
        Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index')->middleware(AuthCheck::class);
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create')->middleware(AuthCheck::class);
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}/info', [UserController::class, 'info'])->where(['id' => '[0-9]+'])->name('user.info')->middleware(AuthCheck::class);
        Route::post('{id}/info/update', [UserController::class, 'changeInfo'])->where(['id' => '[0-9]+'])->name('user.info.update')->middleware(AuthCheck::class);
        Route::post('{id}/info/changeEmail', [UserController::class, 'changeEmail'])->where(['id' => '[0-9]+'])->name('user.info.changeEmail')->middleware(AuthCheck::class);
        Route::post('{id}/info/changePassword', [UserController::class, 'changePassword'])->where(['id' => '[0-9]+'])->name('user.info.changePassword')->middleware(AuthCheck::class);
        Route::get('index', [UserController::class, 'index'])->name('user.index')->middleware(AuthCheck::class);
        Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(AuthCheck::class);
        Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'product/category'], function () {
        Route::get('index', [CategoryProduct::class, 'index'])->name('categoryProduct.index')->middleware(AuthCheck::class);
        Route::get('create', [CategoryProduct::class, 'create'])->name('categoryProduct.create')->middleware(AuthCheck::class);
        Route::post('store', [CategoryProduct::class, 'store'])->name('categoryProduct.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [CategoryProduct::class, 'edit'])->where(['id' => '[0-9]+'])->name('categoryProduct.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [CategoryProduct::class, 'update'])->where(['id' => '[0-9]+'])->name('categoryProduct.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [CategoryProduct::class, 'delete'])->where(['id' => '[0-9]+'])->name('categoryProduct.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [CategoryProduct::class, 'destroy'])->where(['id' => '[0-9]+'])->name('categoryProduct.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'interface/menu'], function () {
        Route::get('index', [MenuController::class, 'index'])->name('menu.index')->middleware(AuthCheck::class);
        Route::get('create', [MenuController::class, 'create'])->name('menu.create')->middleware(AuthCheck::class);
        Route::post('store', [MenuController::class, 'store'])->name('menu.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [MenuController::class, 'edit'])->where(['id' => '[0-9]+'])->name('menu.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [MenuController::class, 'update'])->where(['id' => '[0-9]+'])->name('menu.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [MenuController::class, 'destroy'])->name('menu.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('index', [ProductController::class, 'index'])->name('product.index')->middleware(AuthCheck::class);
        Route::get('create', [ProductController::class, 'create'])->name('product.create')->middleware(AuthCheck::class);
        Route::post('store', [ProductController::class, 'store'])->name('product.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('product.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('product.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.destroy')->middleware(AuthCheck::class);
        Route::get('{id}/editImage', [UploadController::class, 'editImage'])->where(['id' => '[0-9]+'])->name('product.image.edit')->middleware(AuthCheck::class);
        Route::post('{id}/updateImage', [UploadController::class, 'updateImage'])->where(['id' => '[0-9]+'])->name('product.image.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroyImage', [UploadController::class, 'destroyImage'])->name('product.image.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'interface/slider'], function () {
        Route::get('index', [SliderController::class, 'index'])->name('slider.index')->middleware(AuthCheck::class);
        Route::get('create', [SliderController::class, 'create'])->name('slider.create')->middleware(AuthCheck::class);
        Route::post('store', [SliderController::class, 'store'])->name('slider.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [SliderController::class, 'edit'])->where(['id' => '[0-9]+'])->name('slider.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [SliderController::class, 'update'])->where(['id' => '[0-9]+'])->name('slider.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [SliderController::class, 'destroy'])->name('slider.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'attribute/catalogue'], function () {
        Route::get('index', [AttributeController::class, 'index'])->name('attribute.catalogue.index')->middleware(AuthCheck::class);
        Route::get('create', [AttributeController::class, 'create'])->name('attribute.catalogue.create')->middleware(AuthCheck::class);
        Route::post('store', [AttributeController::class, 'store'])->name('attribute.catalogue.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'attribute'], function () {
        Route::get('index', [AttributeValueController::class, 'index'])->name('attribute.index')->middleware(AuthCheck::class);
        Route::get('create', [AttributeValueController::class, 'create'])->name('attribute.create')->middleware(AuthCheck::class);
        Route::post('store', [AttributeValueController::class, 'store'])->name('attribute.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [AttributeValueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [AttributeValueController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.update')->middleware(AuthCheck::class);
        Route::get('{id}/delete', [AttributeValueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.delete')->middleware(AuthCheck::class);
        Route::post('{id}/destroy', [AttributeValueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'coupon'], function () {
        Route::get('index', [CouponController::class, 'index'])->name('coupon.index')->middleware(AuthCheck::class);
        Route::get('create', [CouponController::class, 'create'])->name('coupon.create')->middleware(AuthCheck::class);
        Route::post('store', [CouponController::class, 'store'])->name('coupon.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [CouponController::class, 'edit'])->where(['id' => '[0-9]+'])->name('coupon.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [CouponController::class, 'update'])->where(['id' => '[0-9]+'])->name('coupon.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [CouponController::class, 'destroy'])->name('coupon.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'feeship'], function () {
        Route::get('index', [FeeshipController::class, 'index'])->name('feeship.index')->middleware(AuthCheck::class);
        Route::post('ajax/store', [FeeshipController::class, 'store'])->name('feeship.store')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [FeeshipController::class, 'destroy'])->name('feeship.destroy')->middleware(AuthCheck::class);
        Route::post('ajax/update', [FeeshipController::class, 'update'])->name('feeship.update')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('index', [OrderController::class, 'index'])->name('order.index')->middleware(AuthCheck::class);
        Route::get('{order_code}/order-detail/index', [OrderController::class, 'detailIndex'])->name('order.detail.index')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [OrderController::class, 'destroy'])->name('order.destroy')->middleware(AuthCheck::class);
        Route::post('ajax/update/status', [OrderController::class, 'updateStatus'])->name('order.update.status')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'posts/category'], function () {
        Route::get('index', [CategoryPostsController::class, 'index'])->name('categoryPosts.index')->middleware(AuthCheck::class);
        Route::get('create', [CategoryPostsController::class, 'create'])->name('categoryPosts.create')->middleware(AuthCheck::class);
        Route::post('store', [CategoryPostsController::class, 'store'])->name('categoryPosts.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [CategoryPostsController::class, 'edit'])->where(['id' => '[0-9]+'])->name('categoryPosts.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [CategoryPostsController::class, 'update'])->where(['id' => '[0-9]+'])->name('categoryPosts.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [CategoryPostsController::class, 'destroy'])->name('categoryPosts.destroy')->middleware(AuthCheck::class);
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('index', [PostsController::class, 'index'])->name('posts.index')->middleware(AuthCheck::class);
        Route::get('create', [PostsController::class, 'create'])->name('posts.create')->middleware(AuthCheck::class);
        Route::post('store', [PostsController::class, 'store'])->name('posts.store')->middleware(AuthCheck::class);
        Route::get('{id}/edit', [PostsController::class, 'edit'])->where(['id' => '[0-9]+'])->name('posts.edit')->middleware(AuthCheck::class);
        Route::post('{id}/update', [PostsController::class, 'update'])->where(['id' => '[0-9]+'])->name('posts.update')->middleware(AuthCheck::class);
        Route::post('ajax/destroy', [PostsController::class, 'destroy'])->middleware(AuthCheck::class);
    });
    //Upload
    Route::post('upload/services', [UploadController::class, 'store']);
    // ajax
    Route::get('ajax/category/getCategory', [getCategoryProductController::class, 'getCategory'])->name('ajax.category.index')->middleware(AuthCheck::class);
    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index')->middleware(AuthCheck::class);
    Route::get('{id}/ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index')->middleware(AuthCheck::class);
    Route::post('ajax/dashboard/changeStatus', [DashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus')->middleware(AuthCheck::class);
    Route::post('ajax/dashboard/changeStatusAll', [DashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll')->middleware(AuthCheck::class);
});
    Route::group(['prefix' => '/'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::get('new-product', [HomeController::class, 'new_arrival'])->name('home.new-arrival.index');
        Route::get('top-selling-product', [HomeController::class, 'top_selling'])->name('home.top-selling.index');
        Route::get('flash-sale', [HomeController::class, 'flash_sale'])->name('home.flash-sale.index');
        Route::get('search', [HomeController::class, 'search'])->name('home.search');
        Route::post('ajax/autocomplete', [HomeController::class, 'autocomplete']);
        Route::get('contact', [HomeController::class, 'contact'])->name('home.contact.index');
        Route::get('news', [HomeController::class, 'posts'])->name('home.posts.index');
        Route::get('news/blogs/{slug}', [HomeController::class, 'categoryPosts'])->name('home.category.posts.index');
        Route::get('news/{slug}', [HomeController::class, 'singlePosts'])->name('home.posts.single.index');
        Route::get('collections/{slug}', [HomeController::class, 'category'])->name('home.category.index');
        Route::get('products/{id}%{name}', [HomeController::class, 'product'])->name('home.product.index');
        Route::get('cart', [HomeController::class, 'cart'])->name('cart.index');
        Route::post('gio-hang/check-coupon', [CartController::class, 'checkCoupon'])->name('cart.checkCoupon');
        Route::get('checkouts', [CheckoutController::class, 'checkout'])->name('checkout.index');
        Route::post('checkouts', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');
        Route::get('check-order', [HomeController::class, 'showFormCheckOrder'])->name('home.showFormCheckOrder');
        Route::post('ajax/check-order', [HomeController::class, 'checkOrder'])->name('home.checkOrder');
        //trang-chu
        Route::get('ajax/new-product', [HomeController::class, 'newArrival']);
        Route::get('ajax/top-selling-product', [HomeController::class, 'topSelling']);
        //posts
        Route::post('ajax/bai-viet/comment', [HomeController::class, 'posts_comment'])->middleware(UserCheck::class);
        Route::post('ajax/bai-viet/reply-comment', [HomeController::class, 'posts_replyComment'])->middleware(UserCheck::class);
        Route::post('ajax/bai-viet/remove-comment', [HomeController::class, 'posts_removeComment']);
        //danh-muc
        Route::get('ajax/danh-muc/loadFilterCat', [CategoryController::class, 'filterCategory']);
        //san-pham
        Route::get('ajax/san-pham/loadProductQuickView', [HomeController::class, 'loadQuickView']);
        Route::post('ajax/san-pham/comment', [HomeController::class, 'comment'])->middleware(UserCheck::class);
        Route::post('ajax/san-pham/reply-comment', [HomeController::class, 'replyComment']);
        Route::post('ajax/san-pham/remove-comment', [HomeController::class, 'removeComment']);
        //cart
        Route::post('ajax/add-to-cart', [CartController::class, 'addToCart']);
        Route::post('ajax/update-to-cart', [CartController::class, 'updateToCart']);
        Route::post('ajax/destroy-to-cart', [CartController::class, 'deleteToCart']);
        Route::post('ajax/update-to-cart', [CartController::class, 'updateToCart']);
        Route::post('ajax/destroy-to-coupon', [CartController::class, 'deleteToCoupon']);
        //WishList
        Route::post('ajax/add-to-wishlist', [WishListController::class, 'addToWishList']);
        Route::post('ajax/remove-to-wishlist', [WishListController::class, 'removeToWishList']);
        Route::post('ajax/remove-to-wishlist-all', [WishListController::class, 'removeToWishListAll']);
        //checkout
        Route::get('ajax/calculate-delivery', [CheckoutController::class, 'calculateDelivery']);
        Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation']);
        Route::get('{id}/ajax/location/getLocation', [LocationController::class, 'getLocation']);
        //User
        Route::get('login', [LoginController::class, 'index'])->name('home.user.showForm')->middleware(AlreadyLoggedInUser::class);
        Route::post('login', [LoginController::class, 'login'])->name('home.user.login');
        Route::post('register', [LoginController::class, 'register'])->name('home.user.register');
        Route::get('logout', [LoginController::class, 'logout'])->name('home.user.logout')->middleware(UserCheck::class);
        Route::get('user', [LoginController::class, 'myUser'])->name('home.user.myUser')->middleware(UserCheck::class);
        Route::post('ajax/user/update', [LoginController::class, 'updateUser'])->middleware(UserCheck::class);;
        Route::post('ajax/user/changeEmail', [LoginController::class, 'changeEmail'])->middleware(UserCheck::class);;
        Route::post('ajax/user/changePassword', [LoginController::class, 'changePassword'])->middleware(UserCheck::class);;
});
