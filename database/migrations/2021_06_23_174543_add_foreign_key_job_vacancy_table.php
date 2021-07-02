<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyJobVacancyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('job_vacancy', function(Blueprint $table) {
    	$table->foreign('art_finder_id')
    				->references('id')
    				->on('art_finder')
    				->onUpdate('cascade')
    				->onDelete('cascade');

    	$table->foreign('photo_id')
    				->references('id')
    				->on('photos')
    				->onUpdate('cascade')
    				->onDelete('restrict');
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

  	Schema::table('job_vacancy', function (Blueprint $table) {
      $table->dropForeign(['art_finder_id']);
      $table->dropForeign(['photo_id']);
    });

    Schema::enableForeignKeyConstraints();
  }
}
