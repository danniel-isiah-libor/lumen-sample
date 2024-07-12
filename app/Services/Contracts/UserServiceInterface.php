<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function index();
}
