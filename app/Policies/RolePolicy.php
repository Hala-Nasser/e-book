<?php

namespace App\Policies;

// use App\Models\Role;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    use HandlesAuthorization;

    public function viewAny(Admin $admin)
    {
        return $admin->checkPermissionTo('Read-Roles')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Role $role)
    {
        //
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin)
    {
        return $admin->checkPermissionTo('Create-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Role $role)
    {
        return $admin->checkPermissionTo('Update-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Role $role)
    {
        return $admin->checkPermissionTo('Delete-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Role $role)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Role $role)
    {
        //
    }

    public function editRolePermissions(Admin $admin, Role $role)
    {
        return $admin->checkPermissionTo('Update-Role-Permissions')
        ? $this->allow()
        : $this->deny();
    }
}
