<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    use HandlesAuthorization;

    public function viewAny($actor)
    {
        return $actor->checkPermissionTo('Read-Categories')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view($actor, Category $category)
    {
        return $actor->checkPermissionTo('Read-Category-Subs')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the Admin can create models.
     */
    public function create($actor)
    {
        return $actor->checkPermissionTo('Create-Category')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update($actor, Category $category)
    {
        return $actor->checkPermissionTo('Update-Category')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete($actor, Category $category)
    {
        return $actor->checkPermissionTo('Delete-Category')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore($actor, Category $category)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete($actor, Category $category)
    {
        //
    }
}
