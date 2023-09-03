<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    use HandlesAuthorization;

    public function viewAny($actor)
    {
        return $actor->checkPermissionTo('Read-Books')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view($actor, Book $book)
    {
        //
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create($actor)
    {
        return $actor->checkPermissionTo('Create-Book')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update($actor, Book $book)
    {
        return $actor->checkPermissionTo('Update-Book')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete($actor, Book $book)
    {
        return $actor->checkPermissionTo('Delete-Book')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore($actor, Book $book)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete($actor, Book $book)
    {
        //
    }
}
