# Enhanced Activity Log

The goal of this enhancement is to provide in depth logging details of each API activities across all services.

### **Usage**

In your `public/index.php` file, add a constant:

```php
<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

// To calculate your app execution time
define('LUMEN_START', microtime(true));

$app = require __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$app->run();
```

Add these two new middlewares:

- [RequestMiddleware](app/Http/Middleware/RequestMiddleware.php)

- [ResponseMiddleware](app/Http/Middleware/ResponseMiddleware.php)

***note: don't forget to include other dependencies as well.***

Inside `bootstrap/app.php`, add these new middlewares in this order:

```php
$app->middleware([
    App\Http\Middleware\RequestMiddleware::class,
    App\Http\Middleware\ResponseMiddleware::class
]);
```

