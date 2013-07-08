@extends('layouts.offcanvas')

<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding an array of lists of circles
- Optional
*/
?>

@section('sidebar')
@endsection

@section('main')
<div id="circles-index">
  {{ Form::hidden('_token', csrf_token())}}
  @include('form.field', array('type' => 'text', 'name' => 'filter', 'sl' => false))
  <ul>
    @foreach($d as $type => $circles)
      <li id="circles-{{$type}}" class="columns small-12 large-6">
        <h2>@lang('ui.circles.'.$type)</h2>
        <ul>
          <li id="create">
            <div class="actions">
              {{link_to_route('circles.create',trans('ui.circles.create'),
                 array(), array('class' => 'ajax button expand')) }}
            </div>
          </li>
          @foreach($circles as $circle)
            <li id="circle-{{$circle->id}}">
              @include('circles.item', array('d' => $circle))
            </li>
          @endforeach
        </ul>
      </li>
    @endforeach
  </ul>
</div>
@endsection
