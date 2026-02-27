<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(User::class, 'user');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::all();
		return view('admin.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        dd('Admin\UserController show', $request->input(), $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        dd('Admin\UserController destroy', $user);
    }

	/**
	 * Login as the specified user.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function loginAs(User $user)
	{
		$this->authorize('loginAs', $user);
		Auth::loginUsingId($user->id);
		return redirect()->route('home')->withStatus("Logged in as $user->name.");
	}

	/**
	 * Assign permission to the user.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Spatie\Permission\Models\Permission  $permission
	 * @return \Illuminate\Http\Response
	 */
	public function givePermissionTo(User $user, Permission $permission)
	{
		$this->authorize('givePermissionTo', [$user, $permission]);
		$user->givePermissionTo($permission);
		return redirect()->route('admin.users.edit', $user)->withStatus("Success.");
	}

	/**
	 * Assign role to the user.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Spatie\Permission\Models\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function assignRole(User $user, Role $role)
	{
		$this->authorize('assignRole', [$user, $role]);
		$user->assignRole($role);
		return redirect()->route('admin.users.edit', $user)->withStatus("Success.");
	}
}
