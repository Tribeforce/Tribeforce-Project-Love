<?php

class AgreeController extends \BaseController {

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
  public function create()
  {
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
        $agree = Agree::recycle($input['obj_id'], $input['obj_type']);
        $object = get_poly_object($input['obj_id'], $input['obj_type']);
        if(isset($object)) {
          // Save the agree and show a message
          $agree = $object->agrees()->save($agree);
          $commands = Messages::show('status', 'ui.agrees.success');
          // Replace the agree widget
          $selector = '#'.$input['obj_type'].'-'.$input['obj_id'].' > .agrees';
          $selector = make_html_class($selector);
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
          $commands = Messages::show('warning', 'ui.agree.error');
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
  public function destroy($id) {
    // Get the agree
    $agree = Agree::find($id);

    // Get the object we agreed on
    $object   = $agree->obj;
    $obj_id   = $object->id;
    $obj_type = get_class($object);

    // Delete the agree
    $agree->delete();

    // Show success message
    $commands = Messages::show('status', 'ui.agrees.destroy');

    // Replace the agree widget
    $selector = "#$obj_type-$obj_id > .agrees";
    $selector = make_html_class($selector);
    $commands[] = array(
      'method' => 'replace',
      'selector' => $selector,
      'html' => utf8_encode(View::make('agrees.widget')->with(array(
        'd'   => $object->agrees,
        'obj_id'   => $obj_id,
        'obj_type' => $obj_type,
      ))),
    );

    return $commands;
  }

}
