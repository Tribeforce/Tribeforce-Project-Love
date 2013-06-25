@extends('layouts.offcanvas')


@section('sidebar')
@endsection

@section('main')
<div id="goal-show">
  <div class="goal-{{$d->id}}">
    @include('goals.item')
  </div>
</div>
@endsection
