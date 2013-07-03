<?php

class FriendsController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('own:circles');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }

  public function getIndex($id) {
    $d = User::find($id);
    return View::make('tribe.details')->with(array(
      'title' => $d->full_name,
      'd' => $d,
    ));
  }


  public function getGoals($id) {
    return $this->getObjects($id, 'goal');
  }


  public function getEndorsements($id) {
    return $this->getObjects($id, 'endorsement');
  }

  private function getObjects($id, $type) {
    $c = ucfirst($type);

    $all = $c::where('user_id', '=', $id)
             ->where('child_id', '=', 0)
             ->orderBy('created_at', 'desc')
             ->get();

    $cu = User::current();

    // For performace:
    // If the current user corresponds to the $id, no filtering has to be done
    if($cu->id === $id) {
      $allowed = $all;
    } else {
      // Filter out all the objects accessible to the current user
      $allowed = $all->filter(function($element) {
        return Right::allowed($element);
      });
    }

    return View::make($type . 's.index')->with(array(
      'title' => trans('ui.' . $type . 's.title_' . $type . 's',
                                   array('name' => User::find($id)->full_name)),
      'd' => $allowed,
      'p' => array('own_page' => $cu->id === $id),
      'user_id' => $id,
    ));
  }

}
