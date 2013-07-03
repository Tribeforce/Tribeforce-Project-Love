@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding list of circles
//  $p: the object describing the permissions
//  $user_id: The ID of the person we are showing feedbackables for
- Optional
//  $type: The type of feedbackable (small case)
*/
?>

@section('sidebar')
@endsection

@section('main')
<div id="circles-friends">
  <ul>
    @foreach($d as $user)
      <li id="user-{{$user->id}}">
        @include('users.name', array('d' => $user))
      </li>
    @endforeach
  </ul>
</div>
@endsection
