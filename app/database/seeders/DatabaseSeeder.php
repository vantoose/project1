<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UserSeeder::class);

    if (App::environment('local')) {
      User::factory(9)->create();
      Memo::factory(99)->create();
      Post::factory(99)->create();
    }

    $this->call(RolesSeeder::class);
    
    $this->call(ChatSeeder::class);
  }
}
