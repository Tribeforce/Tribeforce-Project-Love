<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacks extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('feedbacks', function(Blueprint $table) {
      $table->increments('id');
      $table->string('feedback');
      $table->integer('user_id')->unsigned();
      $table->integer('obj_id')->unsigned();
      $table->string('obj_type');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('feedbacks');
  }

}
