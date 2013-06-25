<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbacks
- Optional
*/
?>

@if(isset($d))
  <ul class="feedbacks">
  @foreach($d as $feedback)
    @include('feedback.show', array('d' => $feedback))
  @endforeach
  </ul>
@endif
