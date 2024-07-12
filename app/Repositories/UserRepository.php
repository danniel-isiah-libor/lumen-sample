<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Create the repository instance.
     *
     * @param \App\Models\User
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
