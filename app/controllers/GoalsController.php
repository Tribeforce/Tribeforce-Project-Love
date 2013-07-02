<?php

class GoalsController extends FeedbackableController {
  public function __construct() {
    $this->type = 'goal';
    parent::__construct();
  }
}
