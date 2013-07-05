<?php

class RightsController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $cu = User::current();
    $input = Input::all();
    $selectionFriends = array();
    $selectionCircles = array();


    // Get the rights for the users
    $userRights = Right::where('obj_id', '=', $input['obj_id'])
                       ->where('obj_type', '=', $input['obj_type'])
                       ->where('permission_type', '=', 'User')
                       ->get();

    // Get the rights for the circles
    $circleRights = Right::where('obj_id', '=', $input['obj_id'])
                         ->where('obj_type', '=', $input['obj_type'])
                         ->where('permission_type', '=', 'Circle')
                         ->get();

    // Get all friends and circles
    $friends = $cu->friends;
    $circles = $cu->subscribedCircles;

    // Mark what friends of all have permission on the related object
    foreach($friends as $friend) {
      $selected = false;
      foreach($userRights as $right) {
        if($right->permission->id == $friend->id) {
          $selected = true;
        }
      }

      $selectionFriends[$friend->id] = array(
        'selected' => $selected,
        'user' => $friend,
      );
    }

    // Mark what circles of all have permission on the related object
    foreach($circles as $circle) {
      $selected = false;
      foreach($circleRights as $right) {
        if($right->permission->id == $circle->id) {
          $selected = true;
        }
      }

      $selectionCircles[$circle->id] = array(
        'selected' => $selected,
        'circle' => $circle,
      );
    }

    $html = View::make('rights.widget')->with(array(
      'title' => trans('ui.rights.title_widget'),
      'd' => array('user' => $selectionFriends, 'circle' => $selectionCircles),
      'obj_id' => $input['obj_id'],
      'obj_type' => $input['obj_type'],
    ));

    $commands[] = array(
      'method' => 'overlay',
      'html' => html4ajax($html),
    );

    return Response::json($commands);


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
