<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyArtAcceptedJobTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('art_accepted_job', function(Blueprint $table) {
    	$table->foreign('art_id')
    				->references('id')
    				->on('art')
    				->onUpdate('cascade')
    				->onDelete('cascade');

    	$table->foreign('art_finder_id')
    				->references('id')
    				->on('art_finder')
    				->onUpdate('cascade')
    				->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::disableForeignKeyConstraints();

  	Schema::table('art_accepted_job', function (Blueprint $table) {
      $table->dropForeign(['art_id']);
      $table->dropForeign(['art_finder_id']);
    });

    Schema::enableForeignKeyConstraints();
  }
}
