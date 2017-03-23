# Laravel Enso Core v3.0

A solid base for all laravel-enso packages.

### Configuration steps:

Console/Kernel.php

```php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {

        $logReporting = new LogReporting;
        $logReporting->checkLaravelLog();
    })->everyTenMinutes();
}
```

Exceptions/Handler.php

```php
public function render($request, Exception $exception)
{
    if ($exception instanceof TokenMismatchException) {
        return redirect('/');
    }

    return parent::render($request, $exception);
}
```

Http/Middleware/RedirectIfAuthenticated.php

```php
public function handle($request, Closure $next, $guard = null)
{
    if (Auth::guard($guard)->check()) {

        return redirect('/');
    }

    return $next($request);
}

```

Http/Controllers/Auth/LoginController.php

```php
protected $redirectTo = '/';
```

Http/Controllers/Auth/RegisterController.php => replace content with

```php
public function showRegistrationForm()
{
    return redirect('/');
}

public function register(Request $request)
{
    return redirect('/');
}
```

Http/Controllers/Auth/ResetPasswordController.php

```php
protected $redirectTo = '/';
```

app/Http/Kernel.php => add to $middlewareGroups array

```php
'core' => [

    \LaravelEnso\Core\Http\Middleware\VerifyActiveState::class,
    \LaravelEnso\Core\Http\Middleware\VerifyRouteAccess::class,
    \LaravelEnso\ActionLogger\Http\Middleware\ActionLogger::class,
    \LaravelEnso\Core\Http\Middleware\Impersonate::class,
    \LaravelEnso\Localisation\Http\Middleware\SetLanguage::class
]
```

create in storage\app folder the following folders:

avatars
imports
exports
files
temp

Have fun!!!