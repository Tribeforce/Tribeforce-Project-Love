<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the goal
  $p: the object describing the permissions
- Optional
*/

$parent = $d->parent;
$child = $d->child;
?>

@include('field', array('name' => 'name'))
  @if($p['own_page'])
  {{ link_to_route('goals.create', trans('ui.goals.new'),
     array('original' => $d->id),
     array('class' => 'ajax button small')) }}
  @endif

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
@include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => 'Goal'))
@include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => 'Goal'))
