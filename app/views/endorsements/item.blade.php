<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the endorsement
  $p: the object describing the permissions
- Optional
  $type: The type of feedbackable (small case)
*/

if(!isset($type)) $type = 'endorsement';
$own_page = (isset($p['own_page']) and $p['own_page']);

?>
<div class="columns small-12 large-6">
  <div class="row">
    <div class="columns small-5">
      @include('field', array('name' => 'avatar', 'd' => $d->creator))
    </div>
    <div class="columns small-7">
      <small>
        @include('field', array('name' => 'created_at'))
        <span class="show-for-touch">
        @include('users.name', array('d' => $d->creator, 'avatar' => false))
        </span>
      </small>
      @include('field', array('name' => 'name'))
    </div>
  </div>

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => ucfirst($type), 'i_agree' => $d->iAgree()))

  @if($own_page)
    <div class="controls">
      <div class="columns small-3">
        {{ link_to_route('rights.index', ' ',
           array('obj_id' => $d->id, 'obj_type' => ucfirst($type)),
           array(
             'class' => 'ajax icon-users',
             'title' => trans('ui.rights.title_widget'),
           )
         ) }}
      </div>
    </div>
  @endif

</div>
<div class="columns small-12 large-6">
  @include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => ucfirst($type)))
</div>
