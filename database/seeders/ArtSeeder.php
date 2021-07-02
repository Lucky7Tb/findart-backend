<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  	DB::table('art')->insert([
  		[
  			'user_id' => 4,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_name' => 'Lucky Jhon Mata',
				'art_phone_number' => '08993970968',
				'art_address' => 'Permata kopo',
  			'art_job_status' => 0,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'user_id' => 5,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_name' => 'Muhammad Jhon Doe',
				'art_phone_number' => '08993970967',
				'art_address' => 'Permata kopo',
  			'art_job_status' => 0,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'user_id' => 6,
				'province_id' => '11',
				'city_id' => '1101',
				'district_id' => '1101010',
				'sub_district_id' => '1101010001',
				'photo_id' => 1,
  			'art_name' => 'Amanda Sarah',
				'art_phone_number' => '08993970966',
				'art_address' => 'Permata kopo',
  			'art_job_status' => 0,
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  	]);
  }
}
