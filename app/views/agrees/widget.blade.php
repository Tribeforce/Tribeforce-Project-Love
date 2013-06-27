<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the agrees
  $obj_id   : The id of the object the agrees belong to
  $obj_type : The type of the object the agrees belong to
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
      <?php
      // There seems to be a bug in Laravel. The hidden field should be added
      // automatically, here we add it manually
      ?>
      {{ Form::open(array('route' => array('agree.destroy', $agree->id), 'class' => 'ajax'), 'DELETE') }}
        {{ Form::hidden('_method' , 'DELETE')  }}
        @include('form.field', array('type' => 'submit', 'name' => 'dont-agree', 'size' => 'tiny'))
      {{ Form::close() }}
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
