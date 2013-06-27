<?php

class GoalsController extends \BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
   $cu = User::current();
   $d = Goal::where('user_id', '=', $cu->id)
            ->where('child_id', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

    return View::make('goals.index')->with(array(
      'title' => trans('ui.goals.title_index'),
      'd' => $d,
      'p' => array('own_page' => true),
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    if(Request::ajax()) {
      if(isset($_GET['original'])) {
        $selector = "#goal-".$_GET['original'];

        $html = View::make('goals.create')->with(array(
          'original' => $_GET['original'],
        ));
        $html = '<li class="new-version">'.$html.'</li>';
        $html = html4ajax($html);

        $commands[] = array(
          'method' => 'before',
          'selector' => $selector,
          'html' => $html,
        );

        $commands[] = array(
          'method' => 'hide',
          'selector' => $selector,
        );
      } else {
        $commands[] = array(
          'method' => 'hide',
          'selector' => "#create > .actions",
        );

        $commands[] = array(
          'method' => 'append',
          'selector' => "#create",
          'html' => html4ajax(View::make('goals.create')),
        );

      }

      return Response::json($commands);
    }



  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = Input::all();
    if(Request::ajax()) {
      if(!empty($input['goalname'])) {
        // TODO: Add validation
        $cu = User::current();
        $goal = new Goal(array('name' => $input['goalname']));
        $cu->goals()->save($goal);
        $commands = Messages::show('status', 'ui.goals.success');

        // If this is a new version, the old version needs to be updated with
        // the child id
        if(isset($input['original'])) {
          $original = Goal::find($input['original']);
          $original->child_id = $goal->id;
          $original->save();
        }

      } else {
        $commands = Messages::show('warning', 'ui.goals.empty');
      }

      // The selector for the parent object
      $selector = '#create';

      // Show the button again
      $commands[] = array(
        'method' => 'show',
        'selector' => "$selector .actions",
      );

      // Remove the form injected by AJAX
      $commands[] = array(
        'method' => 'remove',
        'selector' => "$selector div.ajax",
      );

      if(isset($goal)) {
        // Prepare the HTML to be inserted
        $html = '<li class="goal-' . $goal->id . '">'
              . View::make('goals.item')->with(array('d' => $goal))
              . '</li>';

        // Show the button again
        $commands[] = array(
          'method' => 'after',
          'selector' => $selector,
          'html' => utf8_encode($html),
        );
      }

      return $commands;

    } else {
      // TODO: Code for non AJAX call
    }



  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
   $d = Goal::find($id);

    return View::make('goals.show')->with(array(
      'title' => trans('ui.goals.title_show'),
      'd' => $d,
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

}
