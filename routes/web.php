<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});
/*
a、 其实并需要把欢迎页面复制然后改它的URL路径 → 直接改URL路径，把原本从主页'/'改成'别的随便写'就完事了
b、 注意：视图文件命名可以用横杠或下划线，但是不要用点. 除了后缀.blade.php
c、 Route里get方法里的第一个参数'URL路径'这是对于用户在浏览器中的输入而言的；
d、 第二个参数是要去找哪个控制器以及该控制器里的哪个方法来实施具体操作；
e、 name命名代号是Laravel项目文件内部对于这套外部路径和对应的控制器及方法的内部代号，主要写在href里→指代外部路径和控制器方法（所以外部URL路径你可以随意改，只要命名代号不改）
f、 对应的控制器及方法里指向的「视图文件的路径与文件名」也是内部的，并不需要跟外部URL一模一样
g、 总结来说就是：外部用户输入的是c → 然后路由会去找d → d会去找f || 输入c等价于输入e，只不过e是内部代号，这样就允许只要e不改，c就可以随便改 || 内部调用e的格式是两个大括号里面route('代号名')
*/


Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');







