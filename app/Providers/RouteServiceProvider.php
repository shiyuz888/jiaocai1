<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/welcome';    #改动过。 可以跟8.3节提到的Middeleware/RedirectIfAuthenticated.php里的注释内容联动
    //我可以恶搞，原本是在某个条件下会默认返回主页即'/' 而只要把常量HOME的赋值改为欢迎页就能默认返回到欢迎页

    
    protected  $namespace =  'App\\Http\\Controllers';  #3.4节添加

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)   #3.4节添加
                ->group(base_path('routes/web.php'));
        });
    }
}
