<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the user
- Optional
  $avatar: defualt true
*/
?>

@if(isset($d))
  <div class="name-element">
    @if(!isset($avatar) or $avatar)
      @include('field', array('name' => 'avatar'))
    @endif
    <a href="{{ action('FriendsController@getIndex', $d->id) }}" class="user-{{$d->id}}">
      @include('field', array('name' => 'name'))
    </a>
  </div>
@endif
