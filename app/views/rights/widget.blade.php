<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding an array of lists of circles or users
  $obj_id
  $obj_type
- Optional
*/
?>


<div id="rights-widget" class="reveal-modal remove-on-close">
  <h2>@lang('ui.rights.title_widget')</h2>
  @include('form.field', array('type' => 'text', 'name' => 'filter', 'sl' => false))
  {{ Form::open(array('route' => array(snake_case($obj_type) .'s.update', $obj_id), 'method' => 'put')) }}
    <ul>
      @foreach($d as $type => $perms)
        <li>
          <h3>@lang("ui.rights.$type")</h3>
          <ul>
            @foreach($perms as $perm)
              <?php $id = "$type-" . $perm[$type]->id; ?>
              <li id="{{$id}}">
              {{ Form::checkbox("permissions[$type-" . $perm[$type]->id . ']',
                 true, $perm['selected'],
                 array('class' => 'left', 'id' => "cb-$id"))}}
              <label for="cb-{{$id}}">
              @include('users.name', array('d' => $perm[$type]))
              </label>
              </li>
            @endforeach
          </ul>
        </li>
      @endforeach
    </ul>
    @include('form.field', array('type' => 'submit', 'name' => 'save'))
    {{ Form::hidden('obj_type', $obj_type) }}
    {{ Form::hidden('action', 'rights') }}
  {{ Form::close() }}

  <a class="close-reveal-modal">&#215;</a>
</div>
