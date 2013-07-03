@extends('layouts.offcanvas')

@section('sidebar')
@endsection

@section('main')
<div id="tribe-details">
  <h2>@lang("ui.about")</h2>
  {{ link_to_action('FriendsController@getGoals', trans('ui.goals.title_index'), $d->id, array('class' => 'button small')) }}
  {{ link_to_action('FriendsController@getEndorsements', trans('ui.endorsements.title_index'), $d->id, array('class' => 'button small')) }}
  <div data-section-content class="row">
    <div class="columns small-12 large-6">
    @include('field', array('name' => 'avatar'))
    </div>
    <div class="columns small-12 large-6">
    @include('field', array('name' => 'full_name'))
    @include('field', array('name' => 'email'))
    @include('field', array('name' => 'birth_date'))
    {{link_to_route('users.edit', trans('forms.edit'), $d->id, array('class' => 'button small right'))}}
    </div>
  </div>
  {{ link_to('tribe', trans('ui.back'), array('class' => 'left')) }}
</div>
@endsection
