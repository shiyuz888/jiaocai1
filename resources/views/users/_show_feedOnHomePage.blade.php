@if ($feed_items->count() > 0)
  <ul class="list-unstyled">
    @foreach ($feed_items as $mblog)
    <!-- feed_items在StaticPagesController里可以看到，feed可以在User模型里看到 -->
      @include('users._show_mblogs',  ['user' => $mblog->user])
    @endforeach
  </ul>
  <div class="mt-5">
    {!! $feed_items->render() !!}
  </div>
@else
  <p>没有数据！</p>
@endif