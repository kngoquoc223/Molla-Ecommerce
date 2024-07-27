<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\CategoryPosts;
use App\Models\Menu;
use App\Models\CategoryProduct as ModelsCategoryProduct;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    function render($request, Throwable $exception)
    {
            if(request()->is('admin/*')){
            }else{
                if ($this->isHttpException($exception)) {
                        if ($exception->getStatusCode() == 404) {
                            $category_posts=CategoryPosts::where('publish',2)->get();
                            $config=[
                                'css'=> [
                                    '/frontend/assets/css/customize.css',
                                ],
                                'js' => [
                                    '/frontend/library/home.js',
                                ]
                            ];
                            $menus=Menu::where('publish',2)->get();
                            $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
                            $config['title']="Molla - Không tìm thấy trang";
                            $template = 'frontend.errors.404';
                            return response()->view('frontend.home.layout',compact(
                                'template',
                                'config',
                                'menus',
                                'category_products',
                                'category_posts',
                            ));
                        }
                }
                if ($exception instanceof \ErrorException) {
                    $category_posts=CategoryPosts::where('publish',2)->get();
                    $config=[
                        'css'=> [
                            '/frontend/assets/css/customize.css',
                        ],
                        'js' => [
                            '/frontend/library/home.js',
                        ]
                    ];
                    $menus=Menu::where('publish',2)->get();
                    $category_products=ModelsCategoryProduct::where('parent_id',0)->where('publish',2)->get();
                    $config['title']="Molla - Lỗi máy chủ";
                    $template = 'frontend.errors.500';
                    $response= response()->view('frontend.home.layout',compact(
                        'template',
                        'config',
                        'menus',
                        'category_products',
                        'category_posts',
                    ));
                    return  $this->toIlluminateResponse($response,$exception);
                }
            }
            return parent::render($request, $exception);
    }
}
