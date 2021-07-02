<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtFinderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('art_finder', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id', false)->index()->unsigned();
			$table->char('province_id', 2)->index();
			$table->char('city_id', 4)->index();
			$table->char('district_id', 7)->index();
			$table->char('sub_district_id', 10)->index();
			$table->integer('photo_id')->index()->unsigned();
      $table->string('art_finder_name', 100);
			$table->string('art_finder_phone_number', 15)->unique();
			$table->text('art_finder_address');
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
    Schema::dropIfExists('art_finder');
  }
}
