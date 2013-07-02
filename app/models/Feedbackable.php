<?php

class Feedbackable extends Eloquent {

  protected $fillable = array('name', 'description', 'child_id');

  /**
   * Validates input against validation rules.
   *
   * @param string $input Input array
   * @return Validator
   */
  public static function getValidator($input) {
    $rules = array(
      'name'=> 'required|max:255',
      // TODO Type validation
    );

    return Validator::make($input, input_rules($input, $rules));
  }

  /**
   * Checks if the current user is in the list of people who agree
   * @return boolean
   */
  public function iAgree() {
    foreach($this->agrees as $agree) {
      if($agree->owner == User::current()) return true;
    }
    return false;
  }


///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the polymorphic relation with the feedback
   * @return The relationship
   */
    public function feedbacks() {
      return $this->morphMany('Feedback', 'obj')
                  ->withTrashed()
                  ->orderBy('created_at', 'asc');
    }

  /**
   * Set the polymorphic relation with the agree
   * @return The relationship
   */
    public function agrees() {
      return $this->morphMany('Agree', 'obj');
    }

  /**
   * Set the polymorphic relation with the permission
   * @return The relationship
   */
    public function permissions() {
      return $this->morphMany('Right', 'obj');
    }

  /**
   * Set the relation with the owner this Feedbackable belongs to
   * @return The relationship
   */
    public function owner() {
      return $this->belongsTo('User', 'user_id');
    }

  /**
   * Set the parent relation with the previous version of the Goal
   * @return The relationship
   */
    public function parent() {
      return $this->hasOne(get_class($this), 'child_id');
    }

  /**
   * Set the child relation with the next version of the Goal
   * @return The relationship
   */
    public function child() {
      return $this->belongsTo(get_class($this), 'child_id');
    }
}
