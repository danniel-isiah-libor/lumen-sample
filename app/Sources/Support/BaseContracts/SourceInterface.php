<?php

namespace App\Sources\Support\BaseContracts;

interface SourceInterface
{
    /**
     * Get the route for the API endpoint.
     * 
     * @return string
     */
    public function route();

    /**
     * Requires the bearer token in the request header.
     * 
     * @return string
     */
    public function token();
}
