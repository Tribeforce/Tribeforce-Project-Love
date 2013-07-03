@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="user-show">
  {{ Form::model($d, array('url' => 'users/'.$d->id, 'method' => 'put', 'files' => true)) }}
    @if($is_admin)
      @include('form.field', array('type' => 'switch', 'name' => 'activated', 'custom' => true, 'default' => $d->activated))
    @endif

    @include('form.field', array('type' => 'image', 'name' => 'avatar'))

    @include('form.field', array('type' => 'text', 'name' => 'first_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'last_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'email', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'date', 'name' => 'birth_date'))

    @include('form.settings')

    <div class="actions columns small-6">
    @if($d->id == $current_user->id)
      @if( ! $d->facebook_id)
      @lang('forms.connect_with')
      {{ link_to_action('ApplicationController@getFacebook',
                   ' ', null, array('class' => 'icon-facebook')) }}
      @else
        {{ link_to_action('ApplicationController@getForgetFacebook', trans('forms.fb_forget')) }}
      @endif
    @endif
    {{ link_to('tribe/details/'.$d->id, trans('forms.cancel')) }}
    </div>
    <div class="columns small-6">
    @include('form.field', array('type' => 'submit', 'name' => 'save'))
    </div>
  {{ Form::close() }}
</div>
@endsection
