<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SubCategory;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;


class SubCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    use HandlesAuthorization;

    public function viewAny($actor)
    {
        return $actor->checkPermissionTo('Read-SubCategories')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($actor, SubCategory $subCategory)
    {
         return $actor->checkPermissionTo('Read-SubCategory-books')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($actor)
    {
        return $actor->checkPermissionTo('Create-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($actor, SubCategory $subCategory)
    {
        return $actor->checkPermissionTo('Update-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($actor, SubCategory $subCategory)
    {
        return $actor->checkPermissionTo('Delte-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($actor, SubCategory $subCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($actor, SubCategory $subCategory)
    {
        //
    }
}
