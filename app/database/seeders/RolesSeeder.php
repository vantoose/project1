<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$role_admin = Role::where('name', 'admin')->first();
		if (! $role_admin) $role_admin = Role::create(['name' => 'admin']);

		$role_user = Role::where('name', 'user')->first();
		if (! $role_user) $role_user = Role::create(['name' => 'user']);

		$permission_login_as = Permission::where('name', 'login as')->first();
		if (! $permission_login_as) $permission_login_as = Permission::create(['name' => 'login as']);

		$permission_chat = Permission::where('name', 'chat')->first();
		if (! $permission_chat) $permission_chat = Permission::create(['name' => 'chat']);

		$permission_memos = Permission::where('name', 'memos')->first();
		if (! $permission_memos) $permission_memos = Permission::create(['name' => 'memos']);

		$permission_posts = Permission::where('name', 'posts')->first();
		if (! $permission_posts) $permission_posts = Permission::create(['name' => 'posts']);

		$permission_uploads = Permission::where('name', 'uploads')->first();
		if (! $permission_uploads) $permission_uploads = Permission::create(['name' => 'uploads']);

        $role_admin->syncPermissions([$permission_login_as]);
        $role_user->syncPermissions([$permission_chat, $permission_memos]);

		User::find(1)->syncRoles([$role_admin, $role_user])
        ->syncPermissions([$permission_posts, $permission_uploads]);

        if (App::environment('local')) {

            User::find(2)->syncRoles([$role_user]);
            User::find(3)->syncRoles([$role_user])->syncPermissions([$permission_posts]);
            User::find(4)->syncRoles([$role_user])->syncPermissions([$permission_uploads]);
            User::find(5)->syncRoles([$role_user])->syncPermissions([$permission_posts, $permission_uploads]);

        }
    }
}
