<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobVacancyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('job_vacancy', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('art_finder_id', false)->index()->unsigned();
      $table->integer('photo_id', false)->index()->unsigned();
      $table->text('job_description');
      $table->bigInteger('job_payment', false);
      $table->date('job_due_date');
      $table->tinyInteger('is_visible', false)->length(1);
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
    Schema::dropIfExists('job_vacancy');
  }
}
