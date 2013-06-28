@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding list of goals
  $p: the object describing the permissions
  $user_id: The ID of the person we are showing goals for
- Optional
*/
?>

@section('sidebar')
@endsection

@section('main')
<div id="goals-index">
  <ul>
    @if($p['own_page'])
      <li id="create">
        <div class="actions">
          {{ link_to_route('goals.create', trans('ui.goals.create'), null,
             array('class' => 'ajax button expand')) }}
        </div>
      </li>
    @endif
    @foreach($d as $goal)
      <li id="goal-{{$goal->id}}" class="row">
        @include('goals.item', array('d' => $goal))
      </li>
    @endforeach
  </ul>
</div>
@endsection
