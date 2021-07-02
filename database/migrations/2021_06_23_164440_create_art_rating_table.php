<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtRatingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('art_rating', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('art_id', false)->index()->unsigned();
      $table->integer('art_finder_id', false)->index()->unsigned();
      $table->integer('rating', false)->length(5);
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
    Schema::dropIfExists('art_rating');
  }
}
