<!DOCTYPE html>
<html lang="zh-CN">

  <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />


    <title>@yield('title', '第二个参数是缺省值') -- 母板还可以写共同的：第5次做L01 整理网站地图逻辑</title>


    <link rel="icon" type="image/x-icon" href="/images/website-icon.ico" />     <!-- 我自己加的 -->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />   <!-- 这里4.4浏览器缓存 改过，要先关watch-poll 然后把href改成现在这样 -->
  </head>


  <body>


    @include('static_pages._header_nav')


    <div class="container">
      <div class="offset-md-1 col-md-10">
        @include('static_pages._messages')
        @yield('content')
        @include('static_pages._footer')
      </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>  <!--教材7.3用户登录添加-->
  </body>
</html>