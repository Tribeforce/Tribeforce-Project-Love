<?php

class Feedback extends Eloquent {

  protected $fillable = array('feedback', 'user_id');

  /**
   * Validates input against validation rules.
   *
   * @param string $input Input array
   * @return Validator
   */
  public static function getValidator($input) {
    $rules = array(
      'name'=> 'required|max:255',
    );

    return Validator::make($input, input_rules($input, $rules));
  }


///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the polymorphic relation with the source
   * @return The relationship
   */
  public function obj() {
    return $this->morphTo();
  }

  /**
   * Set the relation with the I agree object
   * @return The relation
   */
    public function agrees() {
      return $this->morphMany('Agree', 'obj');
    }

  /**
   * Set the relation with the User this Feedback belongs to
   * @return The relationship
   */
    public function owner() {
      return $this->belongsTo('User', 'user_id');
    }

}
