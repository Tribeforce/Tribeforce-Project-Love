<?php

class Agree extends Eloquent {

  protected $fillable = array('user_id');
  protected $softDelete = true;

  /**
   * Have we agreed on the object yet?
   * @param $obj_id
   * @param $obj_type
   * @return boolean
   */
  public static function self($obj_id, $obj_type, $trashed = false) {
    $query = Agree::where('user_id', '=', User::current()->id)
                  ->where('obj_id', '=', $obj_id)
                  ->where('obj_type', '=', $obj_type);

    if($trashed) {
      $agree = $query->withTrashed()->first();
    } else {
      $agree = $query->first();
    }

    return $agree;
  }

  /**
   * Create a new Agree for the current user or recycles it from the trash
   * @param $obj_id
   * @param $obj_type
   * @return Agree
   */
  public static function recycle($obj_id, $obj_type) {
    $agree = self::self($obj_id, $obj_type, true);
    if(isset($agree)) {
      $agree->restore();
    } else {
      $agree = new Agree(array('user_id'  => User::current()->id));
    }
    return $agree;
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
