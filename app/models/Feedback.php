<?php

class Feedback extends Eloquent {

  protected $fillable = array('feedback', 'user_id');
  protected $softDelete = true;

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

  /**
   * Validates input against validation rules.
   *
   * @param string $input Input array
   * @return Validator
   */
  public function deletable() {
    $object = $this->obj;
    $cu = User::current();

    // TODO: Is it a good idea to trust on the id for equqlity?
    //       For some reason the $this object is bigger than the last object
    // we return TRUE if
    //  - The current user is the owner of the object being commented (A user
    //    can remove all feedbacks on own objects)
    //  - The owner of the last feedback is the current user
    if($object->owner == $cu
     or ($this->id === $object->feedbacks->last()->id and $this->owner == $cu)){
      return true;
    }
    else {
      return false;
    }
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
