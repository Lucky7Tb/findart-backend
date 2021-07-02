<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtInterestedJobTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('art_interested_job', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('art_id', false)->index()->unsigned();
      $table->integer('job_vacancy_id', false)->index()->unsigned();
      $table->tinyInteger('apply_status', false)->length(4);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('art_interested_job');
  }
}
