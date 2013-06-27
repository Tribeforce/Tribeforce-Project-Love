<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedback
  $p
- Optional
*/

$classes = $d->trashed() ? ' class="disabled"': '';
?>

@if(!$d->trashed() or $p['own_page'])
<li id="feedback-{{$d->id}}"{{$classes}}>
  @include('field', array('name' => 'feedback'))
  <small class="post-info">
    <span>@lang('ui.posted')</span>
    <span>@include('users.name', array('d' => $d->owner))</span>
    <span>on</span>
    <span>@include('field', array('name' => 'created_at'))</span>
  </small>
  @if($d->deletable())
    <?php
    // There seems to be a bug in Laravel. The hidden field should be added
    // automatically, here we add it manually
    ?>
    @if($d->trashed())
      {{ Form::open(array('route' => array('feedback.update', $d->id), 'class' => 'ajax'), 'PUT') }}
        {{ Form::hidden('_method' , 'PUT')  }}
        @include('form.field', array('type' => 'submit', 'name' => 'restore', 'size' => 'tiny'))
      {{ Form::close() }}
    @else
      {{ Form::open(array('route' => array('feedback.destroy', $d->id), 'class' => 'ajax'), 'DELETE') }}
        {{ Form::hidden('_method' , 'DELETE')  }}
        @include('form.field', array('type' => 'submit', 'name' => 'destroy', 'size' => 'tiny'))
      {{ Form::close() }}
    @endif
  @endif

  @include('agrees.widget', array('d' => $d->agrees, 'obj_id' => $d->id, 'obj_type' => 'Feedback'))
</li>
@endif
