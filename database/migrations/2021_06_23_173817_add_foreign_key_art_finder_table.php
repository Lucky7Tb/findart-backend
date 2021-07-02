<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyArtFinderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
  	Schema::table('art_finder', function(Blueprint $table) {
			$table->foreign('province_id')
				->references('id')
				->on('provinces')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('city_id')
				->references('id')
				->on('cities')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('district_id')
				->references('id')
				->on('districts')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('sub_district_id')
				->references('id')
				->on('sub_districts')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('photo_id')
				->references('id')
				->on('photos')
				->onUpdate('cascade')
				->onDelete('restrict');

			$table->foreign('user_id')
						->references('id')
						->on('users')
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

  	Schema::table('art_finder', function (Blueprint $table) {
			$table->dropForeign(['province_id']);
			$table->dropForeign(['city_id']);
			$table->dropForeign(['district_id']);
			$table->dropForeign(['sub_district_id']);
			$table->dropForeign(['photo_id']);
			$table->dropForeign(['user_id']);
    });

    Schema::enableForeignKeyConstraints();
  }
}
