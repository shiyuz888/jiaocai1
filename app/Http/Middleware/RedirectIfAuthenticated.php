<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                session()->flash('info', '您已登录，无需再次操作。');   //已登录的auth不能访问注册和登录功能，会出现提示，然后返回下方代码的常量HOME，这个常量就在RouteServiceProvider里，要让它返回主页，那么HOME 就要 = '/'
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
