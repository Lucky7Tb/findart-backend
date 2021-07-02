<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  	$usersId = Db::table('users')->insert([
  		[
  			'username' => 'luckyfinder',
  			'password' => bcrypt('123456789'),
  			'role' => '0',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'username' => 'imamfinder',
  			'password' => bcrypt('123456789'),
  			'role' => '0',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'username' => 'amandafinder',
  			'password' => bcrypt('123456789'),
  			'role' => '0',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'username' => 'luckyart',
  			'password' => bcrypt('123456789'),
  			'role' => '1',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'username' => 'imamart',
  			'password' => bcrypt('123456789'),
  			'role' => '1',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  		[
  			'username' => 'amandaart',
  			'password' => bcrypt('123456789'),
  			'role' => '1',
  			'created_at' => \Carbon\Carbon::now(),
  			'updated_at' => \Carbon\Carbon::now(),
  		],
  	]);
  }
}
