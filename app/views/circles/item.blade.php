<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbackable
  $p: the object describing the permissions
- Optional
  $type: The type of feedbackable (small case)
*/
?>
<h3>{{$d->name}}</h3>
<ul>
  @foreach($d->users as $user)
    <li id="user-{{$user->id}}">
      @include('users.name', array('d' => $user))
    </li>
  @endforeach
</ul>
