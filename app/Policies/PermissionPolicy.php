<?php

namespace App\Policies;

// use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    use HandlesAuthorization;

    public function viewAny(Admin $admin)
    {
        return $admin->checkPermissionTo('Read-Permissions')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Permission $permission)
    {
        //
    }
}
