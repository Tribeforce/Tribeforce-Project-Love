<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the user
- Optional
*/
?>

@if(isset($d))
  <div class="name-element">
    <a href="{{ action('FriendsController@getIndex', $d->id) }}" class="user-{{$d->id}}">
      @include('field', array('name' => 'avatar'))
      @include('field', array('name' => 'full_name'))
    </a>
  </div>
@endif
