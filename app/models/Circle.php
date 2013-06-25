<?php

class Circle extends Eloquent {

  protected $fillable = array('name', 'description', 'type');

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

  public function hasUser($id) {
    foreach($this->users()->get() as $friend) {
      if($friend->id === $id) {
        return true;
      }
    }
    return false;
  }

///////////////////
// RELATIONSHIPS //
///////////////////

  /**
   * Set the polymorphic relation with the permissions
   * @return The relationship
   */
    public function permissions() {
      return $this->morphMany('Right', 'obj');
    }

  /**
   * Set the relation with the User this Cicle belongs to
   * @return The relationship
   */
    public function owner() {
      return $this->belongsTo('User');
    }

  /**
   * Set the relation with the Users in this circle
   * @return The relationship
   */
    public function users() {
      return $this->belongsToMany('User');
    }

}
