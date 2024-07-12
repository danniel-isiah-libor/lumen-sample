<?php

namespace App\Repositories\Contracts;

use App\Repositories\Support\BaseContracts\{
    CreateInterface as Create,
    FindInterface as Find,
    DeleteInterface as Delete,
};

interface UserRepositoryInterface extends Create, Find, Delete
{
    /**
     * Here you insert custom functions.
     */
}
