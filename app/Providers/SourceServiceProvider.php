<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Sources\AuditTrail\Contracts\LogSourceInterface;
use App\Sources\AuditTrail\LogSource;
use App\Sources\Support\BaseContracts\HttpRequestInterface;
use App\Sources\Support\HttpRequest;

class SourceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HttpRequestInterface::class, HttpRequest::class);

        $this->app->bind(LogSourceInterface::class, LogSource::class);
    }
}
