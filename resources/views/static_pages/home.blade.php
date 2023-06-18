@extends('static_pages.mother-page')




@section('content')

@if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('users._write_a_mblog')
        </section>

        <h4>微博列表</h4>
        <hr>
        @include('users._show_feedOnHomePage')

      </div>


      <!-- 边栏 -->
      <aside class="col-md-4">
        <section class="user_info">
          @include('users._show_user_info', ['user' => Auth::user()])
        </section>

        <section class="stats mt-2">
          @include('users._fans_stats', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
  @else

  <!-- 如果登录就显示上面的↑↑ 如果没登录就显示下面的↓↓ 缩进格式我懒得整理了 -->


<div class="bg-light p-3 p-sm-5 rounded">
    <h1>Hello Laravel</h1>
    <p class="lead">
      你现在所看到的是 <a href="https://learnku.com/courses/laravel-essential-training">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('users.create') }}" role="button">现在注册</a>
    </p>
</div>

@endif


@stop
