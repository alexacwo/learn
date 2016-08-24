<?php

namespace App\Repositories;

use App\User;

class TestRepository
{
    /**
     * Get all of the tests for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return $user->tests()
                    ->orderBy('date', 'asc')
                    ->get();
    }
}