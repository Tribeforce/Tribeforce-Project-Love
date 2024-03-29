@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding list of feedbackables
  $p: the object describing the permissions
//  $user_id: The ID of the person we are showing feedbackables for
- Optional
  $type: The type of feedbackable (small case)
*/

if(!isset($type)) $type = 'feedbackable';

?>

@section('sidebar')
@endsection

@section('main')
<div id="{{$type}}s-index">
  <ul>
    @if($p['own_page'])
      <li id="create">
        <div class="actions">
          {{link_to_route($type . 's.create',trans('ui.' . $type . 's.create'),
             array('own_page' => $p['own_page']),
             array('class' => 'ajax button expand')) }}
        </div>
      </li>
    @endif
    @foreach($d as $feedbackable)
      <li id="{{$type}}-{{$feedbackable->id}}" class="row">
        @include($type . 's.item', array('d' => $feedbackable))
      </li>
    @endforeach
  </ul>
</div>
@endsection
