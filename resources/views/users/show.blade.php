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