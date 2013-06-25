<?php

class Agree extends Eloquent {

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
