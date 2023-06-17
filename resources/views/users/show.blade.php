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
      </div>
    </div>
  </div>
</div>
@stop