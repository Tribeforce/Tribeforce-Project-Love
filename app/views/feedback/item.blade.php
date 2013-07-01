<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedback
  $p
- Optional
*/

$classes = $d->trashed() ? 'disabled': '';
$agrees_options = array(
  'd' => $d->agrees,
  'obj_id' => $d->id,
  'obj_type' => 'Feedback',
  'trashed' => $d->trashed(),
  'i_agree' => $d->iAgree(),
);
?>

@if(!$d->trashed() or $p['own_page'])
<li id="feedback-{{$d->id}}" class="{{$classes}}">
  <div class="row">
    <div class="columns small-3">
      @include('field', array('name' => 'avatar', 'd' => $d->owner))
    </div>
    <div class="columns small-9">
      <small>
        @include('field', array('name' => 'created_at'))
        <span class="show-for-touch">
        @include('users.name', array('d' => $d->owner, 'avatar' => false))
        </span>
      </small>
      @include('field', array('name' => 'feedback'))
      <div class="controls">
        @if($d->deletable())
          <?php
          // There seems to be a bug in Laravel. The hidden field should be added
          // automatically, here we add it manually
          ?>
          @if($d->trashed())
            {{ Form::open(array('route' => array('feedback.update', $d->id), 'class' => 'ajax'), 'PUT') }}
              {{ Form::hidden('_method' , 'PUT')  }}
              @include('form.field', array('type' => 'submit', 'name' => 'restore', 'size' => 'tiny', 'icon' => 'arrows-cw' ))
            {{ Form::close() }}
          @else
            {{ Form::open(array('route' => array('feedback.destroy', $d->id), 'class' => 'ajax'), 'DELETE') }}
              {{ Form::hidden('_method' , 'DELETE')  }}
              @include('form.field', array('type' => 'submit', 'name' => 'destroy', 'size' => 'tiny', 'icon' => 'cancel'))
            {{ Form::close() }}
          @endif
        @endif
        @include('agrees.widget', $agrees_options)
      </div>
    </div>
  </div>
</li>
@endif
