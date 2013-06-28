<?php
/*
This template expects following variables:
- Mandatory
  - $obj_id:   the id of the object to add the feedback to
  - $obj_type: the type of the object to add the feedback to
*/
?>

{{ Form::open(array('route' => 'feedback.store')) }}
  {{ Form::hidden('obj_id'  , $obj_id)   }}
  {{ Form::hidden('obj_type', $obj_type) }}
  @include('form.field', array('type' => 'textarea', 'name' => 'feedback', 'sl' => false))
  <div class="actions">
    @include('form.field', array('type' => 'submit', 'name' => 'ready', 'size' => 'tiny'))
<!-- {{ link_to_route('feedback.store', trans('forms.cancel'), null, array('class' => 'ajax button secondary cancel right tiny')) }} -->
  </div>
{{ Form::close() }}
