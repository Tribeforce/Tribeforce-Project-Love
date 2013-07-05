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
  @include('form.field', array('type' => 'text', 'name' => 'filter', 'sl' => false))
  <ul>
    @foreach($d as $type => $circles)
      <li id="circles-{{$type}}">
        <h2>@lang('ui.circles.'.$type)</h2>
        <ul>
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
