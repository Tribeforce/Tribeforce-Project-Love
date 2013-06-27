<?php

class FeedbackController extends \BaseController {

  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    $obj_id   = isset($_GET['obj_id'])   ? $_GET['obj_id']   : '';
    $obj_type = isset($_GET['obj_type']) ? $_GET['obj_type'] : '';

    if(Request::ajax()) {
      $selector = "#create-$obj_id";

      // Hide the actions
      $commands[] = array(
        'method' => 'hide',
        'selector' => "$selector .actions",
      );

      // Append the form
      $commands[] = array(
        'method' => 'append',
        'selector' => "$selector",
        'html' => html4ajax(View::make('feedback.create')->with(array(
          'obj_id'   => $obj_id,
          'obj_type' => $obj_type,
        ))),
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
      // The selector for the parent object
      $selector = "#create-" . $input['obj_id'];

      if(!empty($input['feedback'])) {
        // TODO: Add validation
        $feedback = new Feedback(array(
          'feedback' => $input['feedback'],
          'user_id'  => User::current()->id,
        ));
        $class = ucfirst(camel_case($input['obj_type']));

        // Only continue if the class exists
        if(class_exists($class)) {
          $source = $class::find($input['obj_id']);

          // The source class needs to be the same as asked for (not empty also)
          if(get_class($source) === $class) {
            // Save the feedback and show a message
            $feedback = $source->feedbacks()->save($feedback);
            $commands = Messages::show('status', 'ui.feedback.success');
            // Add the newly added feedback
            $commands[] = array(
              'method' => 'before',
              'selector' => $selector,
              'html' => utf8_encode(View::make('feedback.item')->with(array(
                'd'   => $feedback,
              ))),
            );
          } else {
            $commands = Messages::show('warning', 'ui.feedback.error');
          }
        } else {
          $commands = Messages::show('warning', 'ui.feedback.error');
        }

      } else {
        $commands = Messages::show('warning', 'ui.feedback.empty');
      }

      // Show the feedback button again
      $commands[] = array(
        'method' => 'show',
        'selector' => "$selector .actions",
      );

      // Remove the form injected by AJAX
      $commands[] = array(
        'method' => 'remove',
        'selector' => "$selector div.ajax",
      );

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
