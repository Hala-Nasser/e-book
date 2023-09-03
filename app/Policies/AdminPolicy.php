<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    use HandlesAuthorization;

    public function viewAny($actor)
    {
        return $actor->checkPermissionTo('Read-Admins')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view($actor, Admin $admin)
    {
        //
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create($actor)
    {
        return $actor->checkPermissionTo('Create-Admin')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update($actor, Admin $admin)
    {
        return $actor->checkPermissionTo('Update-Admin')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete($actor, Admin $admin)
    {
        return $actor->checkPermissionTo('Delete-Admin')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore($actor, Admin $admin)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete($actor, Admin $admin)
    {
        //
    }
}
