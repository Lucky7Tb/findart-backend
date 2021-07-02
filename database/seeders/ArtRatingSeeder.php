<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtRatingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
		DB::table('art_rating')->insert([
  		[
  			'art_id' => 1,
  			'art_finder_id' => 1,
  			'rating' => 2,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'art_id' => 1,
  			'art_finder_id' => 2,
  			'rating' => 5,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'art_id' => 2,
  			'art_finder_id' => 3,
  			'rating' => 1,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  	]);
  }
}
