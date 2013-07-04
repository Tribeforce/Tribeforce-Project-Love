<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the agrees
  $obj_id   : The id of the object the agrees belong to
  $obj_type : The type of the object the agrees belong to
  $i_agree
- Optional
  $trashed
*/

$agree = Agree::self($obj_id, $obj_type);
$html_id = make_html_class("agrees-$obj_type-$obj_id");


?>

@if(isset($d))
  <div class="agrees" id="{{$html_id}}-div">
    <div class="text">
      @if(count($d) > 0)
        <a href='#' data-dropdown="{{$html_id}}">
          @choice('ui.agrees.count', count($d), array('count' => count($d)))
        </a>
        <span>@choice('ui.agrees.agree', count($d))</span>
        <ul id="{{$html_id}}" class="dropdown large">
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
    <div class="actions">
      @if(!isset($trashed) or !$trashed)
        @if($i_agree)
          {{ ajaxLink(route('agree.destroy', $agree->id), ' ', 'DELETE', 'icon-heart') }}
        @else
          {{ ajaxLink(route('agree.store'), ' ', 'POST', 'icon-heart-empty',
                         array('obj_id' => $obj_id, 'obj_type' => $obj_type)) }}
        @endif
      @endif
    </div>
  </div>
@endif
