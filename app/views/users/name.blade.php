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
    @include('field', array('name' => 'name'))
  </div>
@endif
