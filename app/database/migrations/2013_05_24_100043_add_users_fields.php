<?php

use Illuminate\Database\Migrations\Migration;

class AddUsersFields extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function($table)
    {
      $table->string('phone', 64)->after('last_name');
      $table->date('birth_date')->after('last_name');
      $table->string('avatar', 255)->after('last_name');
      $table->text('settings')->after('last_name');
      $table->integer('facebook_id')->nullable()->unique()->unsigned()->after('password');
      $table->integer('linkedin_id')->nullable()->unique()->unsigned()->after('password');
      $table->integer('google_id')->nullable()->unique()->unsigned()->after('password');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function($table)
    {
      $table->dropColumn('phone');
      $table->dropColumn('birth_date');
      $table->dropColumn('avatar');
      $table->dropColumn('settings');
      $table->dropColumn('facebook_id');
      $table->dropColumn('linkedin_id');
      $table->dropColumn('google_id');
    });
  }

}
