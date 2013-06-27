{{ Form::open(array('route' => 'goals.store')) }}
  <div class="actions">
    @include('form.field', array('type' => 'submit', 'name' => 'ready', 'size' => 'tiny'))
    {{ link_to_route('goals.store', trans('forms.cancel'), null, array('class' => 'ajax button secondary cancel right tiny')) }}
  </div>
  @include('form.field', array('type' => 'text', 'name' => 'goalname', 'sl' => false))
{{ Form::close() }}
