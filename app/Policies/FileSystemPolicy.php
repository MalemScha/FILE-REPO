<?php

namespace App\Policies;

use App\FileSystem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileSystemPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user)
    {
        return $user->isAdmin == 1;
    }
}
