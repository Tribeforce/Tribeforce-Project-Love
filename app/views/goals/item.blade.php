<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the goal
- Optional
*/

$parent = $d->parent;
$child = $d->child;
?>

@include('field', array('name' => 'name'))
@if(isset($parent))
  <div class="parent left">
    {{ link_to_route('goals.show', trans('ui.goals.parent'), $parent->id) }}
  </div>
@endif
@if(isset($child))
  <div class="child right">
    {{ link_to_route('goals.show', trans('ui.goals.child'), $child->id) }}
  </div>
@endif
@include('feedback.index', array('d' => $d->feedbacks))
@include('agrees.widget', array('d' => $d->agrees))
