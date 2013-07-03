<?php

class EndorsementsController extends FeedbackablesController {
  public function __construct() {
    $this->type = 'endorsement';
    parent::__construct();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = Input::all();
    $c = ucfirst($this->type);

    if(Request::ajax()) {
      if(!empty($input[$this->type . 'name'])) {
        // TODO: Add validation
        $cu = User::current();
        $to_user = User::find($input['user_id']);

        $feedbackable = new $c(array(
          'name' => $input[$this->type . 'name'],
          'created_by' => $cu->id
        ));

        $to_user->endorsements()->save($feedbackable);
        $commands = Messages::show('status', 'ui.' . $this->type . 's.success');
      } else {
        $commands = Messages::show('warning', 'ui.' . $this->type . 's.empty');
      }


      // THE AJAX COMMANDS
      if(isset($feedbackable)) {
        // Prepare the HTML to be inserted
        $html = '<li id="' . $this->type . '-' . $feedbackable->id . '" class="row">'
              . View::make($this->type.'s.item')->with(array(
                  'd' => $feedbackable,
                  'p' => array('own_page' => $input['own_page']),
                ))
              . '</li>';
      } else {
        $html = '';
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

      // Insert the HTML
      $commands[] = array(
        'method' => 'after',
        'selector' => $selector,
        'html' => utf8_encode($html),
      );

      return $commands;

    } else {
      // TODO: Code for non AJAX call
    }



  }


}
