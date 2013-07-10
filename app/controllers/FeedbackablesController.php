<?php

class FeedbackablesController extends \BaseController {
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
//      'user_id' => $cu->id,
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    if(Request::ajax()) {
      $withArray = array(
        'p' => array('own_page' => $_GET['own_page']),
      );

      if($this->type === 'endorsement') {
        $withArray['created_for'] = $_GET['created_for'];
      }
      if(isset($_GET['original'])) {
        $withArray['original'] = $_GET['original'];
      }

      $html = View::make($this->type . 's.create')->with($withArray);

      if(isset($_GET['original'])) {
        $selector = "#" . $this->type . "-".$_GET['original'];
        $timestamp = $_GET['original'];

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

        $commands[] = array(
          'method' => 'focus',
          'selector' => "$selector-new-version [name=" . $this->type . "name]",
        );
      } else {
        $selector = '#create';

        $commands[] = array(
          'method' => 'hide',
          'selector' => "$selector > .actions",
        );

        $commands[] = array(
          'method' => 'append',
          'selector' => $selector,
          'html' => html4ajax($html),
        );

        $commands[] = array(
          'method' => 'focus',
          'selector' => "$selector [name=" . $this->type . "name]",
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
        $html = '<li id="' . $this->type . '-' . $feedbackable->id . '" class="row">'
              . View::make($this->type.'s.item')->with(array(
                  'd' => $feedbackable,
                  'p' => array('own_page' => $input['own_page']),
                ))
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

    if(Request::ajax()) {
      $input = Input::all();

      $html = View::make($this->type . 's.item')->with(array(
        'title' => trans('ui.' . $this->type . 's.title_show'),
        'd' => $d,
      ));

      $html = '<li id="' .$this->type. '-' .$id. '" class="row">'.$html.'</li>';

      $commands[] = array(
        'method' => 'slide',
        'selector' => '#' . $this->type . '-' . $input['original'],
        'direction' => $input['direction'],
        'html' => utf8_encode($html),
      );

      return $commands;

    } else {
      $html = View::make($this->type . 's.show')->with(array(
        'title' => trans('ui.' . $this->type . 's.title_show'),
        'd' => $d,
      ));
      return $html;

    }
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
    $cu = User::current();
    $input = Input::all();
    $c = $input['obj_type'];
    $feedbackable = $c::find($id);

    // Fix the fact that if no permissions are checked, the array is empty
    if(empty($input['permissions'])) {
      $input['permissions'] = array();
    }

    if(Request::ajax()) {
      switch($input['action']) {
        case 'rights';
          $friends = $cu->friends;
          $circles = $cu->subscribedCircles;

          // Normalize the input array
          // TODO: merge arrays or collections to have 1 loop
          foreach($friends as $perm) {
            $normalizedInput[get_class($perm) . '-' . $perm->id] = false;
          }
          foreach($circles as $perm) {
            $normalizedInput[get_class($perm) . '-' . $perm->id] = false;
          }
          $normalizedInput=array_merge($normalizedInput, $input['permissions']);

          foreach($normalizedInput as $key => $item) {
            list($permission_type, $permission_id) = explode('-', $key);

            // Find if a Right exists yet
            $rights = Right::where('obj_id', '=', $id)
                          ->where('obj_type', '=', $input['obj_type'])
                          ->where('permission_id', '=', $permission_id)
                          ->where('permission_type', '=', $permission_type)
                          ->get();

            if($item)  { // The right needs to exist
              // If it doesn't exist, create it
              if(count($rights) === 0) {
                $right = Right::create(array(
                  'permission_id'   => $permission_id,
                  'permission_type' => $permission_type,
                  ));
                $feedbackable->permissions()->save($right);
              }
            } else {  // The Right should not exist
              // If at least 1 exists, delete all of them
                if(count($rights) > 0) {
                  foreach($rights as $right) {
                    $right->delete();
                  }
                }
            }
          }
          break;
      }

      // Remove the overlay injected by AJAX
      $commands[] = array(
        'method' => 'removeOverlay',
        'selector' => "body > div.ajax",
      );

      // Remove the form injected by AJAX
      $commands[] = array(
        'method' => 'remove',
        'selector' => "body > div.ajax",
      );

      return $commands;

    } else {
      // TODO what if no AJAX call?
    }
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
