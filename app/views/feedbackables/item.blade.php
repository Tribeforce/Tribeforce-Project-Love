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

  @if($parent or $own_page or $child)
    <a href="#" data-dropdown="dd-{{$type}}-{{$d->id}}" class="icon-cog controls-button"></a>

    <div id="dd-{{$type}}-{{$d->id}}" class="controls dropdown" data-dropdown-content>
      @if(isset($parent))
        {{ ajaxLink(route($type . 's.show', $parent->id),
           trans('ui.feedbackables.prev'), 'GET', 'icon-left-open',
           array('direction' => 'left', 'original' => $d->id)) }}
      @endif
      @if($own_page)
        {{ link_to_route($type . 's.create', trans('ui.feedbackables.new'),
           array('original' => $d->id, 'own_page' => $p['own_page']),
           array(
             'class' => 'ajax icon-plus',
             'title' => trans('ui.' . $type . 's.new'),
           )
         ) }}
      @endif
      @if($own_page)
        {{ link_to_route('rights.index', trans('ui.feedbackables.permissions'),
           array('obj_id' => $d->id, 'obj_type' => ucfirst($type)),
           array(
             'class' => 'ajax icon-users',
             'title' => trans('ui.rights.title_widget'),
           )
         ) }}
      @endif
      @if(isset($child))
        {{ ajaxLink(route($type . 's.show', $child->id),
           trans('ui.feedbackables.next'), 'GET', 'icon-right-open',
           array('direction' => 'right', 'original' => $d->id)) }}
      @endif
    </div>
  @endif

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => ucfirst($type), 'i_agree' => $d->iAgree()))

</div>
<div class="columns small-12 large-6">
  @include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => ucfirst($type)))
</div>
