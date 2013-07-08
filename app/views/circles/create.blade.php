<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbackable
- Optional
*/

if(!isset($type)) $type = 'circle';

?>

{{ Form::open(array('route' => $type . 's.store')) }}
  <div class="actions">
    @include('form.field', array('type' => 'submit', 'name' => 'ready', 'size' => 'tiny'))
    {{ link_to_route($type . 's.store', trans('forms.cancel'), null, array('class' => 'ajax button secondary cancel right tiny')) }}
  </div>
  @include('form.field', array('type' => 'text', 'name' => 'name', 'sl' => false))
{{ Form::close() }}
