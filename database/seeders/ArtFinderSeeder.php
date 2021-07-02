<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtFinderSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('art_finder')->insert([
  		[
  			'user_id' => 1,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_finder_name' => 'Lucky Tri Bhakti',
				'art_finder_phone_number' => '08993970965',
				'art_finder_address' => 'Permata kopo',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'user_id' => 2,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_finder_name' => 'Muhammad Imam Fernandi',
				'art_finder_phone_number' => '089939709654',
				'art_finder_address' => 'Permata kopo',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'user_id' => 3,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_finder_name' => 'Amanda Aulia Dwi Putri',
				'art_finder_phone_number' => '08993970963',
				'art_finder_address' => 'Permata kopo',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
		]);
  }
}
