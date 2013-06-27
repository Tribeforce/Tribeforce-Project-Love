<?php

class Agree extends Eloquent {

  protected $fillable = array('user_id');

  /**
   * Have we agreed on the object yet?
   * @param $obj_id
   * @param $obj_type
   * @return boolean
   */
  public static function self($obj_id, $obj_type) {
    return Agree::where('user_id', '=', User::current()->id)
                  ->where('obj_id', '=', $obj_id)
                  ->where('obj_type', '=', $obj_type)
                  ->first();
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
   * Set the relation with the I agree object
   * @return The relation
   */
    public function owner() {
      return $this->belongsTo('User', 'user_id');
    }


}
