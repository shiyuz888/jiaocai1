@extends('static_pages.mother-page')


@section('title', '注册')



@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>注册</h5>
    </div>
    <div class="card-body">


            @include('static_pages._errors')      <!--检擦下方表单内输入的内容的格式是否正确-->


      <form method="POST" action="{{ route('users.store') }}">      <!--注意这行 post方法 和post提交之后 通过路由 调用的UserController里的store方法-->
      {{ csrf_field() }}        <!--需要在这里加上这个，否则post方法会过期，这是出于安全考虑，参考教材6.4节-->
      
      
          <div class="mb-3">
            <label for="name">名称：</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
          </div>

          <div class="mb-3">
            <label for="email">邮箱：</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
          </div>

          <div class="mb-3">
            <label for="password">密码：</label>
            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
          </div>

          <div class="mb-3">
            <label for="password_confirmation">确认密码：</label>
            <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
          </div>

          <button type="submit" class="btn btn-primary">注册</button>
      </form>
    </div>
  </div>
</div>
@stop
