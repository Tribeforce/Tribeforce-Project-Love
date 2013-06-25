@extends('layouts.offcanvas')


@section('sidebar')
@endsection

@section('main')
<div id="goal-index">
  <ul>
  @foreach($d as $goal)
    <li class="goal-{{$goal->id}}">
      @include('goals.item', array('d' => $goal))
    </li>
  @endforeach
  </ul>
</div>
@endsection
