<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the user
- Optional
  $avatar: defualt true
  $link: default true
*/

if(!isset($link)) $link = true;
?>

@if(isset($d))
  <div class="name-element">
    @if(!isset($avatar) or $avatar)
      @include('field', array('name' => 'avatar', 'link' => $link))
    @endif
    @include('field', array('name' => 'name'))
  </div>
@endif
