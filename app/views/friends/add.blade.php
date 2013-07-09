<div id="friends-add" class="reveal-modal remove-on-close ui-front">
  <h2>@lang('ui.friends.title_add')</h2>
  <div id="autocomplete">
    @include('form.field', array('type' => 'text', 'name' => 'autocomplete', 'sl' => false))
  </div>
  <div id="result">
    <span class="left delete icon-cancel"></span>
    <span class="result"></span>
  </div>
  {{ Form::open(array('action' => 'FriendsController@postAdd')) }}
    {{ Form::hidden('friend') }}
    @include('form.field', array('type' => 'select', 'name' => 'circle', 'values' => $circles))
    @include('form.field', array('type' => 'submit', 'name' => 'add'))
  {{ Form::close() }}
  <a class="close-reveal-modal">&#215;</a>
</div>
