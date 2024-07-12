<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Ramsey\Uuid\Uuid;

class ResponseMiddleware
{
    /**
     * @var \app\Helper\Contracts\AuthInterface
     */
    protected $auth;

    /**
     * @var \app\Sources\AuditTrail\Contracts\LogSourceInterface
     */
    protected $logSource;

    /**
     * @var array
     */
    protected $logData;

    /**
     * Create the middleware instance and inject its dependencies.
     * 
     * @param App\Helper\Auth
     */
    public function __construct()
    {
        $this->auth = App::make('App\Helper\Contracts\AuthInterface');
        $this->logSource = App::make('App\Sources\AuditTrail\Contracts\LogSourceInterface');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $data = $this->init($request, $response)
            ->getQueries()
            ->getException($response);

        $this->logSource->store($data);

        return $response;
    }

    /**
     * Prepare initial log data.
     * 
     * @param $request
     * @param $response
     * @return mixed
     */
    private function init($request, $response)
    {
        $correlationId = $request->header('correlation-id') ?? Uuid::uuid4()->toString();
        $ip = $request->ip();
        $service = 'merchant';
        $merchantUuid = $this->auth->merchantUuid();
        $userUuid = $this->auth->userUuid();
        $userType = $this->auth->userType();
        $host = $request->getHost();
        $path = $request->getPathInfo();
        $method = $request->method();
        $headers = $request->header();
        $payload = $request->request->all();
        $responseTime = microtime(true) - LUMEN_START;
        $status = $response->getStatusCode();
        $content = $response->getContent();
        $memoryUsage = memory_get_usage();
        $memoryPeakUsage = memory_get_peak_usage();

        $this->logData = [
            'correlation_id' => $correlationId,
            'ip' => $ip,
            'service' => $service,
            'merchant_uuid' => $merchantUuid,
            'user_uuid' => $userUuid,
            'user_type' => $userType,
            'host' => $host,
            'path' => $path,
            'method' => $method,
            'headers' => json_encode($headers, true),
            'payload' => json_encode($payload, true),
            'response_time' => $responseTime,
            'status' => $status,
            'response' => json_encode($content, true),
            'memory_usage' => $memoryUsage,
            'memory_peak_usage' => $memoryPeakUsage,
        ];

        return $this;
    }

    /**
     * Get all performed queries.
     * 
     * @return mixed
     */
    protected function getQueries()
    {
        $data = [];

        $queries = collect(DB::getQueryLog());

        if ($queries->count()) {
            $data = $queries->map(function ($data) {
                $query = $data['query'];
                $bindings = $data['bindings'];

                foreach ($bindings as $value) {
                    $value = is_numeric($value) ? $value : "'" . $value . "'";
                    $query = preg_replace('/\?/', $value, $query, 1);
                }

                $data['query'] = $query;

                return $data;
            })->toArray();
        }

        $this->logData['queries'] = $data;

        return $this;
    }

    /**
     * Get exception data.
     * 
     * @return mixed
     */
    protected function getException($response)
    {
        $data = [];

        $exception = $response->exception;

        if ($exception) {
            $data = [
                'status' => $response->getStatusCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        $this->logData['exception'] = $data;

        return $this;
    }
}
