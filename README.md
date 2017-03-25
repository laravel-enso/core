# Laravel Enso Core v3.0
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ba5e8fe6e1dc427590d9bad7721ca037)](https://www.codacy.com/app/laravel-enso/Core?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/Core&amp;utm_campaign=Badge_Grade)

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

create in storage\app folder the following folders:

avatars
imports
exports
files
temp

delete default users table migration

### Note

AppServiceProvider will create the following middleware group

```php


```php
'core' => [

    \LaravelEnso\Core\App\Http\Middleware\VerifyActiveState::class,
    \LaravelEnso\Core\App\Http\Middleware\VerifyRouteAccess::class,
    \LaravelEnso\ActionLogger\App\Http\Middleware\ActionLogger::class,
    \LaravelEnso\Core\App\Http\Middleware\Impersonate::class,
    \LaravelEnso\Core\App\Http\Middleware\SetLanguage::class,
]
```

### Try also

laravel-enso/commentsmanager
laravel-enso/documentsmanager
laravel-enso/tutorialmanager
laravel-enso/localisation

Have fun!!!
