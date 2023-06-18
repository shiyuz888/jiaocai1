<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;    //需要添加
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirm_email']     //除了show、create、store、index、confirm_email方法可以访问之外，未登录者不允许访问本控制器的其他方法，即除了特例之外，所有方法只能由已登录者访问
        ]);


        $this->middleware('guest', [
            'only' => ['create']        //只有guest才能访问create方法，那么就相当于已登录的auth不能访问注册功能
        ]);


        // 注册限流 一个小时内只能提交 10 次请求； 要哪个方法限流就写哪个方法进去，但我好奇的是它是针对同一个IP吗？
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }
    //中括号里的方法名 同 函数名，如果你的注册方法叫signup，那么你就要在中括号里写signup，而不是create



    public function create()
    {
        return view('users.signup');    //这里我没有用教材的users.create → 只是想展示一下view()括号里的内部视图路径名并不需要跟路由里的外部URL 即第一个参数同名，也不需要跟路由的name代号同名
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        // 上面只是检查格式并配合error子视图弹窗提示。下面是真正验证后提交到数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        //下面这段本来是注册就可以登录，现在改为注册后要先激活，所以下面这段就改到了confirm_email方法里去了
        /*
        Auth::login($user); //这行是若新注册成功则自动会进入已登录状态，表现为导航栏的菜单自动变更（需要添加use Illuminate\Support\Facades\Auth; ）
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
        // 上面这行等价于 return redirect()->route('users.show', [$user->id]); 因为此时 $user 是 User 模型对象的实例。route() 方法会自动获取 Model 的主键，也就是数据表 users 的主键 id ，这里是一个『约定优于配置』的体现
        */

        //本来是注册了就进入上方login，即直接可登录，现在改为下方这段，注册了会先发邮件同时返回主页 —— 用户收到邮件点击超链接回来之后的验证登录动作交给confirm_email方法了
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
        //至此发邮件的动作就交给了下方↓↓↓的sendEmailConfirmationTo方法
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.activation-confirm';   //这是指定使用的哪个视图
        $data = compact('user');
        // $from = 'summer@example.com';
        // $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        // Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {     //env里设置好了from和name就不需要它们了，除非你想邮件中用别的抬头
        //     $message->from($from, $name)->to($to)->subject($subject);
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirm_email($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
    //上方store方法+send...方法+confirm_email方法组成了 注册时即发送邮件，用户收到邮件后点链接回来之后就激活账户的动作




    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    public function index()
    {
        $users = User::paginate(10);
        //$users = User::all();
        return view('users.index', compact('users'));
    }




    public function edit(User $user)
    {
        $this->authorize('update', $user);  //8.3节授权策略在该方法上生效（自己只能编辑自己）

        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {

        $this->authorize('update', $user);  //8.3节授权策略在该方法上生效（自己只能编辑自己）

        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'    //原本这里的nullable是required，如果是required那么下面不需要做一个data数组以及判断，现在允许“为空”，那么下面要做数组和判断。即允许用户只改用户名不改密码，也允许用户只改密码，或者两个都改
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }


    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);     //跟edit、update方法下方第一行一样，需要规定登录的人才能访问该方法（其他附加授权条件见UserPolicy等等）
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }



}
