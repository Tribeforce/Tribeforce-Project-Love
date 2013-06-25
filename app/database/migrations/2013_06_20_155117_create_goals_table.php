<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('goals', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->smallInteger('status')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->integer('child_id')->unsigned();
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
    Schema::drop('goals');
  }

}
