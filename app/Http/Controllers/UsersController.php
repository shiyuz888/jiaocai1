<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;    //需要添加
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']     //除了show、create、store方法可以访问之外，未登录者不允许访问本控制器的其他方法，即除了特例之外，所有方法只能由已登录者访问
        ]);


        $this->middleware('guest', [
            'only' => ['create']        //只有guest才能访问create方法，那么就相当于已登录的auth不能访问注册功能
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

        Auth::login($user); //这行是若新注册成功则自动会进入已登录状态，表现为导航栏的菜单自动变更（需要添加use Illuminate\Support\Facades\Auth; ）
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
        // 上面这行等价于 return redirect()->route('users.show', [$user->id]); 因为此时 $user 是 User 模型对象的实例。route() 方法会自动获取 Model 的主键，也就是数据表 users 的主键 id ，这里是一个『约定优于配置』的体现
    }





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
