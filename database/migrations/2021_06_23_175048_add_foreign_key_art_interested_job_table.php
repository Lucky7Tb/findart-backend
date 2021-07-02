<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyArtInterestedJobTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('art_interested_job', function(Blueprint $table) {
    	$table->foreign('art_id')
    				->references('id')
    				->on('art')
    				->onUpdate('cascade')
    				->onDelete('cascade');

    	$table->foreign('job_vacancy_id')
    				->references('id')
    				->on('job_vacancy')
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

  	Schema::table('art_interested_job', function (Blueprint $table) {
      $table->dropForeign(['art_id']);
      $table->dropForeign(['job_vacancy_id']);
    });

    Schema::enableForeignKeyConstraints();
  }
}
