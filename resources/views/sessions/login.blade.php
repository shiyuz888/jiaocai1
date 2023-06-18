@extends('static_pages.mother-page')
@section('title', '登录')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>登录</h5>
    </div>
    <div class="card-body">
      @include('static_pages._errors')

      <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}    <!--post方法都要跟这个确保安全和表单不过期 吧。。。-->

          <div class="mb-3">
            <label for="email">邮箱：</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
          </div>

          <div class="mb-3">
            <label for="password">密码：（ <a href="{{ route('resetRequestPage') }}">忘记密码点这里</a> ）</label>
            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
          </div>

            
          <div class="mb-3">
            <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">     <!--记住我参数remember-->
            <label class="form-check-label" for="exampleCheck1">记住我</label>
          </div>


          <button type="submit" class="btn btn-primary">登录</button>
      </form>

      <hr>

      <p>还没账号？<a href="{{ route('users.create') }}">现在注册！</a></p>
    </div>
  </div>
</div>
@stop