<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedback
- Optional
*/
?>
<li class="feedback-{{$d->id}}">
  @include('field', array('name' => 'feedback'))
  <small class="post-info">
    <span>@lang('ui.posted')</span>
    <span>@include('users.name', array('d' => $d->owner))</span>
    <span>on</span>
    <span>@include('field', array('name' => 'created_at'))</span>
  </small>

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => 'feedback'))
</li>
