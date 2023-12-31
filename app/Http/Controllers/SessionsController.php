<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth; //要添加 ←教材7.2


class SessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);

        // 登录限流 10 分钟十次。要哪个方法限流就写哪个方法进去，但我好奇的是它是针对同一个IP吗？
        $this->middleware('throttle:10,10', [
            'only' => ['store']
        ]);
    }



    public function create()
    {
        return view('sessions.login');      //同样的，view括号内的内部指向视图文件路径名，我也没有跟create方法同名，再次强调，括号里的login指向内部视图，跟function名、跟路由的外部URL路径名、跟路由的name代号不需要保持一致
    }


    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

        // 上面只是检查格式并配合error子视图弹窗提示。下面是真正验证后提交到数据库
        if (Auth::attempt($credentials, $request->has('remember'))) {       //记住我参数remember
            //如果是已经激活的话
            if(Auth::user()->activated) {
            
            // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');
            $fallback = route('users.show', Auth::user());  //8.3节友好的重定向（我个人认为实际现实情况下，不太需要这个功能，因为我记得之前做的时候发现一个不太合理的场景，但是忘记了）
            return redirect()->intended($fallback);
            
            //如果还没有激活的话
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

            //如果没有注册过或者注册也激活了但账密输错了的话↓
        } else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
 
    }


    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }


}
