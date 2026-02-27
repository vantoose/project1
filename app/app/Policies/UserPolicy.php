<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

	/**
	 * Determine whether the user can login as the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function loginAs(User $user, User $model)
	{
		return $user->can('login as');
	}

	/**
	 * Determine whether the user can give permission to the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @param  \Spatie\Permission\Models\Permission  $permission
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function givePermissionTo(User $user, User $model, Permission $permission)
	{
        return $user->hasRole('admin');
	}

	/**
	 * Determine whether the user can assign role to the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @param  \Spatie\Permission\Models\Role  $role
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function assignRole(User $user, User $model, Role $role)
	{
        return $user->hasRole('admin');
	}

    /**
     * Determine whether the user can chat with the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function chatWith(User $user, User $model)
    {
        return $user->can('chat') && $user->isNot($model);
    }
}
