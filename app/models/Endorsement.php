<?php

class Endorsement extends Feedbackable {

  protected $fillable = array('name', 'created_by');

///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the relation with the User this Goal belongs to
   * @return The relationship
   */
  public function creator() {
    return $this->belongsTo('User', 'created_by');
  }

}
