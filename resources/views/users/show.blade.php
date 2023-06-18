@extends('static_pages.mother-page')




@section('title', $user->name)




@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <div class="col-md-12">
      <div class="offset-md-2 col-md-8">
        <section class="user_info">
          @include('users._show_user_info', ['user' => $user])
        </section>

        <!-- 显示关注和取消关注按钮 -->
        @if (Auth::check())
          @include('users._follow_unfollow_btn')
        @endif


        <!-- 显示关注、粉丝、微博数 -->
        <section class="stats mt-2">
          @include('users._fans_stats', ['user' => $user])
        </section>


        <!-- 显示微博 -->
        <section class="mblog">
          @if ($mblogs->count() > 0)
            <ul class="list-unstyled">
              @foreach ($mblogs as $mblog)
                @include('users._show_mblogs')
              @endforeach
            </ul>

            <div class="mt-5">
              {!! $mblogs->render() !!}
              <!-- render渲染分页 -->
            </div>

          @else
            <p>没有数据！</p>
          @endif
        </section>

      </div>
    </div>
  </div>
</div>
@stop