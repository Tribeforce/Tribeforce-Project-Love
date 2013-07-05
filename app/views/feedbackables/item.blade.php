<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbackable
  $p: the object describing the permissions
- Optional
  $type: The type of feedbackable (small case)
*/

if(!isset($type)) $type = 'feedbackable';

$parent = $d->parent;
$child = $d->child;

$own_page = (isset($p['own_page']) and $p['own_page']);

?>
<div class="columns small-12 large-6">
  @include('field', array('name' => 'name'))

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => ucfirst($type), 'i_agree' => $d->iAgree()))

  @if($parent or $own_page or $child)
    <div class="controls">
      <div class="columns small-3">
        @if(isset($parent))
          <div class="parent left">
            {{ link_to_route($type . 's.show', ' ', $parent->id,
               array(
                 'class' => 'icon-left-open',
                 'title' => trans('ui.' . $type . 's.parent'),
                )
            ) }}
          </div>
        @endif
      </div>
      <div class="columns small-3">
        @if($own_page)
          {{ link_to_route($type . 's.create', ' ',
             array('original' => $d->id, 'own_page' => $p['own_page'], 'user_id' => $user_id),
             array(
               'class' => 'ajax icon-plus',
               'title' => trans('ui.' . $type . 's.new'),
             )
           ) }}
        @endif
      </div>
      <div class="columns small-3">
        @if($own_page)
          {{ link_to_route('rights.index', ' ',
             array('obj_id' => $d->id, 'obj_type' => ucfirst($type)),
             array(
               'class' => 'ajax icon-users',
               'title' => trans('ui.rights.title_widget'),
             )
           ) }}
        @endif
      </div>
      <div class="columns small-3">
        @if(isset($child))
          <div class="child right">
            {{ link_to_route($type . 's.show', ' ', $child->id,
               array(
                 'class' => 'icon-right-open',
                 'title' => trans('ui.' . $type . 's.child'),
                )
            ) }}
          </div>
        @endif
      </div>
    </div>
  @endif
</div>
<div class="columns small-12 large-6">
  @include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => ucfirst($type)))
</div>
