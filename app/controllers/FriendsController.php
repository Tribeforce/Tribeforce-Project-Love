<?php

class FriendsController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('own:circles', array('except' => array(
      'postAdd',
      'getAdd',
      'getAutocomplete'
    )));
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

  public function getFriends($id) {
    $user = User::find($id);
    $friends = $user->getFriends();

    return View::make('circles.friends')->with(array(
      'title' => trans('ui.circles.title_friends',
                                         array('name' => $user->full_name)),
      'd' => $friends,
    ));
  }

  public function getAdd() {
    if(Request::ajax()) {
      $cu = User::current();
      $circles =  array();

      // TODO: Make more elegant
      foreach($cu->ownCircles as $circle) {
        $circles[$circle->id] = $circle->name;
      }

      $html = View::make('friends.add')->with(array(
        'title' => trans('ui.friends.title_add'),
        'circles' => $circles,
      ));

      $selector = '#friends-add #autocomplete input';

      $commands[] = array(
        'method' => 'overlay',
        'html' => utf8_encode($html),
      );

      $commands[] = array(
        'method' => 'makeAutocomplete',
        'selector' => $selector,
      );

      $commands[] = array(
        'method' => 'click',
        'selector' => $selector,
      );

      return Response::json($commands);
    } else {
      // TODO What to do if no AJAX?
    }
  }

  public function getAutocomplete() {
    if(Request::ajax()) {
      $term = Input::get('term');

      $results = User::where('first_name', 'LIKE', "%$term%")
                     ->orWhere('last_name', 'LIKE', "%$term%")
                     ->orWhere('email', 'LIKE', "%$term%")
                     ->get();


      $jsonArray = array();
      foreach($results as $user) {
        $html = View::make('users.name')->with(array('d' => $user));

        $jsonArray[] = array(
          'id' => $user->id,
          'label' => utf8_encode($html),
          'value' => $user->full_name,
        );
      }

      return Response::json($jsonArray);
    } else {
      // TODO What to do if no AJAX?
    }
  }

  public function postAdd() {
    $input = Input::all();
    $circle = Circle::find($input['circle']);

    // Handle request to add a friend to a circle
    // TODO validation
    // TODO check that the circle is of own
    if(!$circle->hasUser($input['friend'])) {
      $circle->users()->attach($input['friend']);
    }

    return Redirect::route('circles.index');
  }


  private function getObjects($id, $type) {
    $cu = User::current();
    $c = ucfirst($type);

    if($type === 'endorsement') {
      $all = $c::where('created_for', '=', $id);
    } else {
      $all = $c::where('user_id', '=', $id);
    }

    $all = $all->where('child_id', '=', 0)
               ->orderBy('created_at', 'desc')
               ->get();


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

    $withArray = array(
      'title' => trans('ui.' . $type . 's.title_' . $type . 's',
                                   array('name' => User::find($id)->full_name)),
      'd' => $allowed,
      'p' => array('own_page' => $cu->id === $id),
      'created_for' => $id,
    );

    return View::make($type . 's.index')->with($withArray);
  }

}
