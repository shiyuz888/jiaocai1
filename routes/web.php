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

上面的总结你可以通过下方Route::get('/users/create', 'UsersController@create')->name('users.create'); 与UsersController里的create方法所关联的signup视图页面 这个例子来体会
实际上，在页面你点击现在注册，你会发现浏览器URL输入栏里显示的是/user/create  ————所以只要用的还是同一个控制器的同一个方法，就不需要新做一个什么signup的路由
★★★再简单点概括就是：控制器的方法指向的内部view视图页面的文件名，不需要参照路由里的任何一个参数，包括外部URL路径、控制器方法名、路由name代号★★★
*/


Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');



// Route::get('/signup', 'UsersController@create')->name('signup'); //这次我没做这条路由，因为resource已经带上了create方法了

Route::resource('users', 'UsersController');
/*上面这行等价于下面
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::post('/users', 'UsersController@store')->name('users.store');

Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users', 'UsersController@index')->name('users.index');

Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
*/



Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');
// ↑有两个路由的命名完全一致，但由于我们在表单中清楚的指明了使用 POST 动作来提交用户的登录信息，因此 Laravel 会自动将该请求映射到会话控制器的 store 动作上。————我自己做的话我会分开命名的



Route::get('/users/create/confirm/{token}', 'UsersController@confirm_email')->name('confirm_email');





Route::get('password/reset',  'PasswordController@resetRequestPage')->name('resetRequestPage');
Route::post('password/email',  'PasswordController@sendVerifyLinkEmail')->name('sendVerifyLinkEmail');
Route::get('password/reset/{token}',  'PasswordController@resetPwdForm')->name('resetPwdForm');
Route::post('password/reset',  'PasswordController@updateNewPwd')->name('updateNewPwd');