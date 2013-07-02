<?php

class FeedbackableController extends \BaseController {
  protected $type = 'feedbackable';

  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('own:' . $this->type, array('only' => array(
        'show',
        'edit',
        'update',
        'destroy',
    )));
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $cu = User::current();
     $c = ucfirst($this->type);

    $d = $c::where('user_id', '=', $cu->id)
           ->where('child_id', '=', 0)
           ->orderBy('created_at', 'desc')
           ->get();

    return View::make($this->type . 's.index')->with(array( // TODO
      'title' => trans('ui.' . $this->type . 's.title_index'),
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
        $selector = "#" . $this->type . "-".$_GET['original']; // TODO
        $timestamp = $_GET['original'];

        $html = View::make($this->type . 's.create')->with(array(
          'original' => $_GET['original'],
        ));
        $html = '<li id="' . $this->type . '-' . $_GET['original']
              . '-new-version">'.$html.'</li>';
        $html = html4ajax($html, $timestamp);

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
          'html' => html4ajax(View::make($this->type . 's.create')),
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
    $c = ucfirst($this->type);

    if(Request::ajax()) {
      if(!empty($input[$this->type . 'name'])) {
        // TODO: Add validation
        $cu = User::current();
        $feedbackable = new $c(array('name' => $input[$this->type . 'name']));
        $feedbackables = $this->type . 's';
        $cu->$feedbackables()->save($feedbackable);
        $commands = Messages::show('status', 'ui.' . $this->type . 's.success');

        // If this is a new version, the old version needs to be updated with
        // the child id
        if(isset($input['original'])) {
          $original = $c::find($input['original']);
          $original->child_id = $feedbackable->id;
          $original->save();
        }

      } else {
        $commands = Messages::show('warning', 'ui.' . $this->type . 's.empty');
      }


      // THE AJAX COMMANDS
      if(isset($feedbackable)) {
        // Prepare the HTML to be inserted
        $html = '<li id="' . $this->type . '-' . $feedbackable->id . '">'
              .View::make($this->type.'s.item')->with(array('d'=>$feedbackable))
              . '</li>';
      } else {
        $html = '';
      }

      if(isset($input['original'])) {
        // The selector for the parent object
        $selector = '#' . $this->type . '-' . $input['original'];

        // Remove the form injected by AJAX
        $commands[] = array(
          'method' => 'remove',
          'selector' => "div.ajax.ts-" . $input['original'],
        );

        // Show the original
        $commands[] = array(
          'method' => 'show',
          'selector' => $selector,
        );

        // If a new feedbackable has been created, replace the old one
        if(isset($feedbackable)) {
          // Replace the HTML
          $commands[] = array(
            'method' => 'replace',
            'selector' => $selector,
            'html' => utf8_encode($html),
          );
        }

      } else {
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
   $c = ucfirst($this->type);
   $d = $c::find($id);

    return View::make($this->type . 's.show')->with(array(
      'title' => trans('ui.' . $this->type . 's.title_show'),
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
