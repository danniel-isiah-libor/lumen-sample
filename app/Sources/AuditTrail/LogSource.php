<?php

namespace App\Sources\AuditTrail;

use App\Sources\Source;
use App\Sources\AuditTrail\Contracts\LogSourceInterface;
use App\Sources\Support\BaseContracts\HttpRequestInterface;

class LogSource extends Source implements LogSourceInterface
{
    /**
     * Create the source instance and declare the route endpoint.
     * 
     * @param App\Sources\Support\BaseContracts\HttpRequestInterface $http
     */
    public function __construct(HttpRequestInterface $http)
    {
        $this->route = sprintf('%s/logs', env('AUDIT_TRAIL_SERVICE_URL'));
        $this->http = $http;
    }
}
