<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbackable
  $p: the object describing the permissions
- Optional
  $type: The type of feedbackable (small case)
  $original
*/

if(!isset($type)) $type = 'feedbackable';

?>

{{ Form::open(array('route' => $type . 's.store')) }}
  <div class="actions">
    @include('form.field', array('type' => 'submit', 'name' => 'ready', 'size' => 'tiny'))
    {{ link_to_route($type . 's.store', trans('forms.cancel'), null, array('class' => 'ajax button secondary cancel right tiny')) }}
  </div>
  @if(isset($original))
    {{ Form::hidden('original', $original) }}
  @endif
  {{ Form::hidden('own_page', $p['own_page']) }}
  @include('form.field', array('type' => 'text', 'name' => $type . 'name', 'sl' => false))
{{ Form::close() }}
