<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbacks
  $obj_id
  $obj_type
- Optional
*/
?>

@if(isset($d))
  <ul class="feedbacks">
    @foreach($d as $feedback)
      @include('feedback.item', array('d' => $feedback))
    @endforeach
    <li id="create-{{$obj_id}}" class="ajax">
       @include('feedback.create', array('obj_id' => $obj_id, 'obj_type' => $obj_type))
    </li>
<!--
    <li id="create-{{$obj_id}}">
      <div class="actions">
        {{ link_to_route('feedback.create', trans('ui.feedback.create') ,
           array(
             'obj_id'   => $obj_id,
             'obj_type' => $obj_type,
            ),
            array('class' => 'ajax button expand small')) }}
      </div>
    </li>
-->
  </ul>
@endif
