<?php
/*
This template expects following variables:
- Mandatory
  $d: the object holding the feedbackable
- Optional
*/
?>
<h3>{{$d->name}}</h3>
<ul>
  @foreach($d->users as $user)
    <li id="user-{{$user->id}}" class="row">
      {{ ajaxLink(route('circles.update', $d->id), ' ', 'PUT', 'icon-cancel left', array('del' => $user->id)) }}
      @include('users.name', array('d' => $user))
    </li>
  @endforeach
</ul>
