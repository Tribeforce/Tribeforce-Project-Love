<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackablesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('feedbackables', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('user_id')->unsigned();
      $table->integer('child_id')->unsigned();
      $table->smallInteger('type')->unsigned();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('feedbackables');
  }

}
