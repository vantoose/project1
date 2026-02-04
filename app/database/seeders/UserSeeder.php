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
    DB::table('users')->insert([
      'name' => 'Ivan Shipilov',
      'email' => 'www@ishipilov.ru',
      'email_verified_at' => now(),
      'password' => App::environment('local') ? Hash::make('password') : Hash::make(Str::random(10)),
      'remember_token' => Str::random(10),
      'api_token' => App::environment('local') ? Hash::make('password') : Hash::make(Str::random(10)),
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}