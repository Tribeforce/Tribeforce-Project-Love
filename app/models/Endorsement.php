<?php

class Endorsement extends Eloquent {

  protected $fillable = array('name', 'description');

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
   * Set the polymorphic relation with the feedback
   * @return The relationship
   */
    public function feedbacks() {
      return $this->morphMany('Feedback', 'obj');
    }

  /**
   * Set the polymorphic relation with the agree
   * @return The relationship
   */
    public function agrees() {
      return $this->morphMany('Agree', 'obj');
    }

  /**
   * Set the polymorphic relation with the agree
   * @return The relationship
   */
    public function permissions() {
      return $this->morphMany('Right', 'obj');
    }

  /**
   * Set the relation with the owner this Goal belongs to
   * @return The relationship
   */
    public function owner() {
      return $this->belongsTo('User');
    }

  /**
   * Set the relation with the User this Goal belongs to
   * @return The relationship
   */
    public function creator() {
      return $this->belongsTo('User', 'created_by');
    }

}
