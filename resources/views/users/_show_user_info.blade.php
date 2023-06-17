<a href="{{ route('users.show', $user->id) }}">
  <img src="{{ $user->gravatar('140') }}" alt="{{ $user->name }}" class="gravatar"/>
</a>




<h1>用户名： {{ $user->name }}</h1>

<!-- 下面是我加的，让用户信息显示的多一点
用php artisan tinker创建第一个用户时，生成的字段有name、email、password，
然后实际自动生成了用户的id、name、email、email_verified_at、password、remember_token、created_at、updated_at -->
<p>用户id： {{ $user->id }}</p>
<p>用户邮箱： {{ $user->email }}</p>
<p>邮箱验证状态： {{ $user->email_verified_at }}</p>
<p>用户密码： {{ $user->password }}</p>
<p>“记住我”令牌状态： {{ $user->remember_token }}</p>
<p>用户创建于： {{ $user->created_at }}</p>
<p>用户更新于： {{ $user->updated_at }}</p>