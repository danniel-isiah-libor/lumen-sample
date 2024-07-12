<?php

namespace App\Sources\Support\BaseContracts;

interface StoreInterface
{
    /**
     * POST request to the API store endpoint.
     * 
     * @param array $request
     * @return mixed
     */
    public function store(array $request);
}
