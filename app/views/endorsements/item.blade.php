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

?>
<div class="columns small-12 large-6">
  <div class="row">
    <div class="columns small-6">
      @include('field', array('name' => 'avatar', 'd' => $d->creator))
    </div>
    <div class="columns small-6">
      @include('field', array('name' => 'name'))
    </div>
  </div>

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => ucfirst($type), 'i_agree' => $d->iAgree()))

</div>
<div class="columns small-12 large-6">
  @include('feedback.index', array('d' => $d->feedbacks, 'obj_id' => $d->id, 'obj_type' => ucfirst($type)))
</div>
