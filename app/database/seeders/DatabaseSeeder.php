<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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


		$role_admin = Role::where('name', 'admin')->first();
		if (! $role_admin) $role_admin = Role::create(['name' => 'admin']);

		$permission_login_as = Permission::where('name', 'login as')->first();
		if (! $permission_login_as) $permission_login_as = Permission::create(['name' => 'login as']);

    $role_admin->syncPermissions($permission_login_as);

		$permission_memos = Permission::where('name', 'manage memos')->first();
		if (! $permission_memos) $permission_memos = Permission::create(['name' => 'manage memos']);

		$permission_posts = Permission::where('name', 'manage posts')->first();
		if (! $permission_posts) $permission_posts = Permission::create(['name' => 'manage posts']);

		$permission_uploads = Permission::where('name', 'manage uploads')->first();
		if (! $permission_uploads) $permission_uploads = Permission::create(['name' => 'manage uploads']);


		User::find(1)->syncRoles($role_admin)
    ->syncPermissions([
      $permission_memos,
      $permission_posts,
      $permission_uploads,
    ]);

    if (App::environment('local')) {

      User::factory(9)->create();
      Memo::factory(99)->create();
      Post::factory(49)->create();

    }
  }
}
