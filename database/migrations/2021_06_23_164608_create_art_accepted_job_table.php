<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtAcceptedJobTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('art_accepted_job', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('art_id', false)->index()->unsigned();
      $table->integer('art_finder_id', false)->index()->unsigned();
      $table->tinyInteger('job_status', false)->length(4);
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
    Schema::dropIfExists('art_accepted_job');
  }
}
