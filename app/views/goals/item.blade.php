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
<div class="columns small-12 large-6">
  @include('field', array('name' => 'name'))

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => 'Goal', 'i_agree' => $d->iAgree()))

  <div class="controls">
    <div class="columns small-4">
      @if(isset($parent))
        <div class="parent left">
          {{ link_to_route('goals.show', ' ', $parent->id,
             array(
               'class' => 'icon-left-open',
               'title' => trans('ui.goals.parent'),
              )
          ) }}
        </div>
      @endif
    </div>
    <div class="columns small-4">
      @if(isset($p['own_page']) and $p['own_page'])
        {{ link_to_route('goals.create', ' ',
           array('original' => $d->id),
           array(
             'class' => 'ajax icon-plus',
             'title' => trans('ui.goals.new'),
           )
         ) }}
      @endif
    </div>
    <div class="columns small-4">
      @if(isset($child))
        <div class="child right">
          {{ link_to_route('goals.show', ' ', $child->id,
             array(
               'class' => 'icon-right-open',
               'title' => trans('ui.goals.child'),
              )
          ) }}
        </div>
      @endif
    </div>
  </div>
</div>
<div class="columns small-12 large-6">
  @include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => 'Goal'))
</div>
