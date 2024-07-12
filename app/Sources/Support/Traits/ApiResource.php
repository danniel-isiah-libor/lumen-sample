<?php

namespace App\Sources\Support\Traits;

use Illuminate\Support\Arr;

trait ApiResource
{
    /**
     * POST request to the API store endpoint.
     * 
     * @param array $request
     * @return mixed
     */
    public function store(array $request)
    {
        Arr::set($headers, 'Accept', 'application/json');

        if ($this->token) Arr::set($headers, 'Authorization', $this->token);

        return $this->http->post($this->route, $request, $headers);
    }
}
