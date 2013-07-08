<?php

class Endorsement extends Feedbackable {

  protected $fillable = array('name');

///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the relation with the User who created this Endorsement
   * @return The relationship
   */
  public function creator() {
    return $this->belongsTo('User', 'user_id');
  }

  /**
   * Set the relation with the user this Endorsement has been created for
   * @return The relationship
   */
    public function owner() {
      return $this->belongsTo('User', 'created_for');
    }


}
