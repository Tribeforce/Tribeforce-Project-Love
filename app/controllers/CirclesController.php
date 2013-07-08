<?php

class CirclesController extends \BaseController {

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
    $d = array(
      'own' => $cu->ownCircles,
      'subscribed' => $cu->subscribedCircles
    );

    return View::make('circles.index')->with(array(
      'title' => trans('ui.circles.title_index'),
      'd' => $d,
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    if(Request::ajax()) {
      $selector = '#circles-own #create';

      $commands[] = array(
        'method' => 'hide',
        'selector' => "$selector > .actions",
      );

      $commands[] = array(
        'method' => 'append',
        'selector' => $selector,
        'html' => html4ajax(View::make('circles.create')),
      );

      $commands[] = array(
        'method' => 'focus',
        'selector' => "$selector [name=name]",
      );

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
      if(!empty($input['name'])) {
        // TODO: Add validation
        $cu = User::current();
        $circle = new Circle(array('name' => $input['name']));
        $cu->ownCircles()->save($circle);
        $commands = Messages::show('status', 'ui.circles.success');
      } else {
        $commands = Messages::show('warning', 'ui.circles.empty');
      }


      // THE AJAX COMMANDS

      // The selector for the parent object
      $selector = '#circles-own #create';

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

      if(isset($circle)) {
        // Prepare the HTML to be inserted
        $html = '<li id="circle-' . $circle->id . '">'
              . View::make('circles.item')->with(array(
                  'd' => $circle,
                ))
              . '</li>';

        // Insert the HTML
        $commands[] = array(
          'method' => 'after',
          'selector' => $selector,
          'html' => utf8_encode($html),
        );

        // Make the newly entered item droppable
        $commands[] = array(
          'method' => 'makeDroppable',
          'selector' => '#circles-own #circle-' . $circle->id,
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
  public function show($id)
  {
    //
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
  public function update($id) {
    $input = Input::all();
    $circle = Circle::find($id);

    // Handle add request
    if(isset($input['add'])) {
      $user = User::find($input['add']);
      $circle->users()->attach($user);

      $selector = "#circle-$id";

      $commands[] = array(
        'method' => 'html',
        'selector' => $selector,
        'html' => utf8_encode(View::make('circles.item')->with(array(
          'd' => $circle,
        ))),
      );
    }

    // Handle delete request
    if(isset($input['del'])) {
      $user = User::find($input['del']);
      $circle->users()->detach($user);

      $commands[] = array(
        'method' => 'remove',
        'selector' => "#circle-$id #user-" . $user->id,
      );

    }

    return Response::json($commands);
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
