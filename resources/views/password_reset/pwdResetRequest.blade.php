@extends('static_pages.mother-page')
@section('title', '重置密码')

@section('content')
<div class="col-md-8 offset-md-2">
  <div class="card ">
    <div class="card-header"><h5>重置密码</h5></div>

    <div class="card-body">
      @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
      @endif
      <!--这个session status我没看明白是啥-->

      <form class="" method="POST" action="{{ route('sendVerifyLinkEmail') }}">
        {{ csrf_field() }}

        <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email" class="form-control-label">邮箱地址：</label>

          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

          @if ($errors->has('email'))
            <span class="form-text">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
        </div>

        <div class="mb-3">
          <button type="submit" class="btn btn-primary">
            发送密码重置邮件
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection