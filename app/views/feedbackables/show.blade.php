@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding list of goals
  $p: the object describing the permissions
  $user_id: The ID of the person we are showing goals for
- Optional
  $type: The type of feedbackable (small case)
*/

if(!isset($type)) $type = 'feedbackable';

?>


@section('sidebar')
@endsection

@section('main')
<div id="{{$type}}s-show">
  <div id="{{$type.'-'.$d->id}}">
    @include($type . 's.item')
  </div>
</div>
@endsection
