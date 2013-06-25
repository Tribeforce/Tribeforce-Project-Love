<?php

class FriendsController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('own:circles');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }

  private function allowed($element) {
    return Right::allowed($elemet, User::current());
  }

  public function getIndex($id) {
    $d = User::find($id);
    return View::make('tribe.details')->with(array(
      'title' => $d->full_name,
      'd' => $d,
    ));
  }


  public function getGoals($id) {
    $all = Goal::where('user_id', '=', $id)
               ->where('child_id', '=', 0)
               ->get();

    // Filter out all the goals accessible to the current user
    $allowed = $all->filter(function($element){
      return Right::allowed($element, User::current());
    });

    return View::make('goals.index')->with(array(
      'title' => trans('ui.goals.title_goals', array('name' => User::find($id)->full_name)),
      'd' => $allowed,
    ));
  }

}
