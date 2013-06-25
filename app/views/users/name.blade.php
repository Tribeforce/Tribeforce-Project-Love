<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the user
- Optional
*/
?>

@if(isset($d))
<a href="{{ action('FriendsController@getIndex', $d->id) }}" class="user-{{$d->id}}">
  @include('field', array('name' => 'full_name'))
</a>
@endif