<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the agrees
  $obj_id   : The id of the object the agrees belong to
  $obj_type : The type of the object the agrees belong to
- Optional
  $trashed
*/

$agree = Agree::self($obj_id, $obj_type);
$html_id = make_html_class("agrees-$obj_type-$obj_id");
?>

@if(isset($d))
  <div class="agrees row" id="{{$html_id}}-div">
    <div class="columns small-10 text">
      @if(count($d) > 0)
        <a href='#' data-dropdown="{{$html_id}}">
          @choice('ui.agrees.count', count($d), array('count' => count($d)))
        </a>
        <span>@choice('ui.agrees.agree', count($d))</span>
        <ul id="{{$html_id}}" class="dropdown">
          @foreach($d as $agree)
            <li>
            @include('users.name', array('d' => $agree->owner))
            </li>
          @endforeach
        </ul>
      @elseif(!isset($trashed) or !$trashed)
        @lang('ui.agrees.first')
      @endif
    </div>
    <div class="columns small-2 actions">
      @if(!isset($trashed) or !$trashed)
        @if(empty($agree))
          {{ Form::open(array('route' => 'agree.store', 'class' => 'ajax')) }}
            {{ Form::hidden('obj_id'  , $obj_id)   }}
            {{ Form::hidden('obj_type', $obj_type) }}
              @include('form.field', array('type' => 'submit', 'name' => 'agree', 'size' => 'tiny', 'icon' => 'heart'))
          {{ Form::close() }}
        @else
          <?php
          // There seems to be a bug in Laravel. The hidden field should be added
          // automatically, here we add it manually
          ?>
          {{ Form::open(array('route' => array('agree.destroy', $agree->id), 'class' => 'ajax'), 'DELETE') }}
            {{ Form::hidden('_method' , 'DELETE')  }}
            @include('form.field', array('type' => 'submit', 'name' => 'dont-agree', 'size' => 'tiny', 'icon' => 'heart-empty'))
          {{ Form::close() }}
        @endif
      @endif
    </div>
  </div>
@endif
