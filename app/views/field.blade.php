<?php
/*
This template expects following variables:
- Mandatory
  $name: The name of the field
  $d: the object holding the fields
- Optional
  $label

The label will be taken from the language file lang/<language>/forms.php
*/

// If the value cannot be retrieved, we return empty
if(!method_exists($d, 'getAttribute')) exit;

$val = nl2br($d->getAttribute($name));

if($name === 'full_name') {
  $val = trans('ui.you');
}


switch($name) {
  case 'avatar':
    $type = 'image';
    break;
  case 'email':
    $type = 'email';
    break;
  default:
    $type = 'all';
}
?>

@if($type === 'image')
  <a href="{{ action('FriendsController@getIndex', $d->id) }}" class="image {{$name}}">
  @if(empty($val))
    <img src="/images/{{$name}}.png" title="{{$d->full_name}}">
  @else
    <img src="/files/{{$val}}.small">
  @endif
    <div class="image-overlay"></div>
  </a>
@else
  @if(!empty($val))
  <div class="{{$name}}">
    @if(isset($label) && $label)
      <h5>@lang("forms.$name")</h5>
    @endif
    @if($type === 'email')
      {{HTML::mailto($val, null, array('target' => '_blank'))}}
    @else
      {{$val}}
    @endif
  </div>
  @endif
@endif
