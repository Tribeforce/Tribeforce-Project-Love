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
      @include('field', array('name' => 'avatar', 'd' => $d->owner, 'link' => true))
    </div>
    <div class="columns small-9">
      <small>
        @include('field', array('name' => 'created_at'))
        <span class="show-for-touch">
        @include('users.name', array('d' => $d->owner, 'avatar' => false))
        </span>
      </small>
      @include('field', array('name' => 'feedback'))
      @include('agrees.widget', $agrees_options)

      @if($d->deletable())
        <a href="#" data-dropdown="dd-feedback-{{$d->id}}" class="icon-cog controls-button"></a>
        <div id="dd-feedback-{{$d->id}}" class="controls dropdown" data-dropdown-content>
          @if($d->trashed())
            {{ ajaxLink(route('feedback.update', $d->id), trans('forms.restore'), 'PUT', 'icon-arrows-cw') }}
          @else
            {{ ajaxLink(route('feedback.destroy', $d->id), trans('forms.destroy'), 'DELETE', 'icon-cancel') }}
          @endif
        </div>
      @endif
    </div>
  </div>
</li>
@endif
