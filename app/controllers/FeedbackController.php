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

        $object = get_poly_object($input['obj_id'], $input['obj_type']);
        if(isset($object)) {
          // Save the feedback and show a message
          $feedback = $object->feedbacks()->save($feedback);
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
  public function update($id) {
    // Restore the feedback
    $feedback = Feedback::withTrashed()->find($id);
    $feedback->restore();

    // Show success message
    $commands = Messages::show('status', 'ui.feedback.restored');

    // We undo the greyed out (removeclass)
    $selector = "#feedback-$id";

    // Prepare the parameter to see if we are on an object we own
    $own_page = $feedback->obj->owner == User::current();
    $html = View::make('feedback.item')->with(array(
      'd' => $feedback,
      'p' => array('own_page' => $own_page),
    ));

    $commands[] = array(
      'method' => 'replace',
      'selector' => $selector,
      'html' => utf8_encode($html),
    );

    return $commands;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    // Get the feedback
    $feedback = Feedback::find($id);

    // Get the object we gave feedback on
    $object   = $feedback->obj;
    $obj_id   = $object->id;
    $obj_type = snake_case(get_class($object));

    // Delete the feedback
    $feedback->delete();

    // Show success message
    $commands = Messages::show('status', 'ui.feedback.destroy');

    // If we are looking at feedback of an object of our own, we grey the
    // feedback out (adding a class). Otherwise, we remove it from the DOM
    $selector = "#feedback-$id";

    if($object->owner == User::current()) {
      // The restore function doesn't update the object. This is why we call it again
      $feedback = Feedback::withTrashed()->find($id);

      // Prepare the parameters
      $own_page = $feedback->obj->owner == User::current();
      $html = View::make('feedback.item')->with(array(
        'd' => $feedback,
        'p' => array('own_page' => $own_page),
      ));

      $commands[] = array(
        'method' => 'replace',
        'selector' => $selector,
        'html' => utf8_encode($html),
      );
    } else {
      $commands[] = array(
        'method' => 'remove',
        'selector' => $selector,
      );
    }

    return $commands;
  }

}
