@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding list of endorsements
  $p: the object describing the permissions
  $created_for: The ID of the person we are showing endorsements for
- Optional
  $type: The type of feedbackable (small case)
*/

if(!isset($type)) $type = 'endorsement';

?>

@section('sidebar')
@endsection

@section('main')
<div id="{{$type}}s-index">
  <ul>
    @if(!$p['own_page'])
      <li id="create">
        <div class="actions">
          {{link_to_route($type . 's.create',trans('ui.' . $type . 's.create'),
             array('own_page' => $p['own_page'], 'created_for' => $created_for),
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
