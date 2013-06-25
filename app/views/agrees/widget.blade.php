<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the agrees
- Optional
*/
?>

@if(isset($d) and count($d) > 0)
  <div class="agrees">
    <div class="count">@lang('ui.agrees.count', array('count' => count($d))):</div>
    <ul class="inline-list">
      @foreach($d as $agree)
        <li>
        @include('users.name', array('d' => $agree->owner))
        </li>
      @endforeach
    </ul>
  </div>
@endif
