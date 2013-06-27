<?php

class AgreeController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    dpm('i');
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    dpm('c');
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = Input::all();
    if(Request::ajax()) {
      $cu = User::current();

      // We can only agree once
      // If we agree yet, we show a message, otherwise we continue
      if(Agree::self($input['obj_id'], $input['obj_type'])) {
        $commands = Messages::show('status', 'ui.agrees.once');
      } else {
        $agree = new Agree(array('user_id'  => $cu->id));
        $class = ucfirst(camel_case($input['obj_type']));

        // Only continue if the class exists
        if(class_exists($class)) {
          $object = $class::find($input['obj_id']);

          // The object class needs to be the same as asked for (not empty also)
          if(get_class($object) === $class) {
            // Save the agree and show a message
            $agree = $object->agrees()->save($agree);
            $commands = Messages::show('status', 'ui.agrees.success');
            // Add the newly added agree
            $selector ='.'.$input['obj_type'].'-'.$input['obj_id'].' > .agrees';
            $commands[] = array(
              'method' => 'replace',
              'selector' => $selector,
              'html' => utf8_encode(View::make('agrees.widget')->with(array(
                'd'   => $object->agrees,
                'obj_id'   => $input['obj_id'],
                'obj_type' => $input['obj_type'],
              ))),
            );
          } else {
            $commands = Messages::show('warning', 'ui.feedback.error');
          }
        } else {
          $commands = Messages::show('warning', 'ui.feedback.error');
        }
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
    dpm('s');
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
    dpm('e');
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
    dpm('u');
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    dpm('sdfdsfds');

    $agree = Agree::find($id);
    $agree->delete();

  }

}
