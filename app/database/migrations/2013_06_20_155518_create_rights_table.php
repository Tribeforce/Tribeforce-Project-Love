<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRightsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('rights', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('obj_id')->unsigned();
      $table->string('obj_type');
      $table->integer('permission_id')->unsigned();
      $table->string('permission_type');
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
    Schema::drop('rights');
  }

}
