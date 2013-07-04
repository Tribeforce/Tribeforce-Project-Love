<?php

class CirclesController extends \BaseController {

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
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
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
