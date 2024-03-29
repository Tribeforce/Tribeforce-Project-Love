<?php

class Right extends Eloquent {

  protected $fillable = array('permission_id', 'permission_type');


  /**
   * Check if an object has the right to be viewed by a "permission object"
   *                                                              (user, circle)
   * @return boolean TRUE if the object can be viewed
   */
  public static function allowed($obj, $permission_obj = null) {
    $cu = User::current();
    if(!isset($permission_obj)) $permission_obj = $cu;
    $obj_type = get_class($obj);
    $permission_type = get_class($permission_obj);

    // We always have the right to see our own stuff
    if($obj->owner == $cu) return true;

    // We always have the right to see what we created ourselves
    if($obj->creator == $cu) return true;

    // First we check directly to "permission objects". If at least 1 entry is
    // returned, the right is granted
    $num_rights = Right::where('obj_id', '=', $obj->id)
                       ->where('obj_type', '=', $obj_type)
                       ->where('permission_id', '=', $permission_obj->id)
                       ->where('permission_type', '=', $permission_type)
                       ->count();
    if($num_rights > 0) return true;

    // If the "permission object" is a User, we need to loop through the
    // circles the object has been granted rights to, to check if the user
    // is in the circle.
    // If it is, we return true. If no match has been found we return false.
    if($permission_type === 'User') {
      $rights = Right::where('obj_id', '=', $obj->id)
                      ->where('obj_type', '=', $obj_type)
                      ->where('permission_type', '=', 'Circle')
                      ->get();
      foreach($rights as $right) {
        $circle = Circle::find($right->permission_id);
        if($circle->hasUser($permission_obj->id)) return true;
      }
    }

    return false;
  }


///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the polymorphic relation with the object
   * @return The relationship
   */
    public function obj() {
      return $this->morphTo();
    }

  /**
   * Set the polymorphic relation with the permission
   * @return The relationship
   */
    public function permission() {
      return $this->morphTo();
    }
}
