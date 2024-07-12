<?php

namespace App\Services;

use App\Repositories\Contracts\RepositoryInterface;
use App\Services\Contracts\ServiceInterface;

abstract class Service implements ServiceInterface
{
    /**
     * Primary repository of the service.
     * 
     * @var \App\Repositories\Contracts\RepositoryInterface
     */
    protected $repository;

    /**
     * Create the instance of the service.
     *
     * @param \App\Repositories\Contracts\RepositoryInterface
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Repository instance of the service.
     * 
     * @return \App\Repositories\Contracts\RepositoryInterface
     */
    public function repository()
    {
        return $this->repository;
    }
}
