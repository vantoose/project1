<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $password = Hash::make(Str::random(10));
    $api_token = Hash::make(Str::random(10));
    
    if (App::environment('local')) {
      $password = Hash::make('password');
      $api_token = Hash::make('password');
    }

    DB::table('users')->insert([
      'name' => 'Ivan',
      'email' => 'www@ishipilov.ru',
      'email_verified_at' => now(),
      'password' => $password,
      'remember_token' => Str::random(10),
      'api_token' => $api_token,
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}