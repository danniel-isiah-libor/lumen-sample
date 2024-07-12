<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;

class UserService extends Service implements UserServiceInterface
{
    /**
     * @var \App\Actions\User\Search
     */
    protected $searchAction;

    /**
     * Create the service instance and inject its repository.
     *
     * @param App\Repositories\Contracts\UserRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function index()
    {
        $this->repository->model()->create(['email' => 'test@mail.test']);

        return true;
    }
}
