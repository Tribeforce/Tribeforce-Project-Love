<?php

class GoalsController extends FeedbackablesController {
  public function __construct() {
    $this->type = 'goal';
    parent::__construct();
  }
}
