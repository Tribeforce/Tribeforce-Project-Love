@extends('layouts.offcanvas')


@section('sidebar')
@endsection

@section('main')
<div id="goals-show">
  <div id="goal-{{$d->id}}">
    @include('goals.item')
  </div>
</div>
@endsection
