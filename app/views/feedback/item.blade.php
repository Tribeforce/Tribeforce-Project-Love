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
            {{ ajaxLink(route('feedback.update', $d->id), ' ', 'PUT', 'icon-arrows-cw') }}
          @else
            {{ ajaxLink(route('feedback.destroy', $d->id), ' ', 'DELETE', 'icon-cancel') }}
          @endif
        @endif
        @include('agrees.widget', $agrees_options)
      </div>
    </div>
  </div>
</li>
@endif
