<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the agrees
  $obj_id
  $obj_type
- Optional
*/

$agree = Agree::self($obj_id, $obj_type);

?>

@if(isset($d))
  <div class="agrees">
    @if(count($d) > 0)
    <div class="count">@lang('ui.agrees.count', array('count' => count($d))):</div>
    @endif
    @if(empty($agree))
      {{ Form::open(array('route' => 'agree.store', 'class' => 'ajax')) }}
        {{ Form::hidden('obj_id'  , $obj_id)   }}
        {{ Form::hidden('obj_type', $obj_type) }}
          @include('form.field', array('type' => 'submit', 'name' => 'agree', 'size' => 'tiny'))
      {{ Form::close() }}
    @else
      {{-- Form::open(array('route' => array('agree.destroy', $agree->id), 'class' => 'ajax')) --}}
      {{-- Form::close() --}}
    @endif
    @if(count($d) > 0)
    <ul class="inline-list">
      @foreach($d as $agree)
        <li>
        @include('users.name', array('d' => $agree->owner))
        </li>
      @endforeach
    </ul>
    @endif
  </div>
@endif
