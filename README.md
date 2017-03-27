# Laravel Enso Core
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ba5e8fe6e1dc427590d9bad7721ca037)](https://www.codacy.com/app/laravel-enso/Core?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/Core&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://styleci.io/repos/85807594/shield?branch=master)](https://styleci.io/repos/85807594)
[![Total Downloads](https://poser.pugx.org/laravel-enso/core/downloads)](https://packagist.org/packages/laravel-enso/core)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/core/version)](https://packagist.org/packages/laravel-enso/core)

Laravel Enso can be a solid start for any Laravel Based project.

### List of features

 ... will be covered soon. We are working on a more comprehensive tutorial but for now wysiwyg.

### Installation

Warning: for now, use this package only on a fresh install of Laravel

1. run `laravel new project`

2. set .env file

3. in the project folder run `composer require laravel-enso/core`

4. delete `database/migrations/create_users_table.php` (laravel default migration for users table) and resources/views/welcome.blade.php.

5. add `LaravelEnso\Core\CoreServiceProvider::class` to the providers list in config/app.php

6. run `php artisan vendor:publish --force` - this will publish all you need in order to use the app.

7. run `php artisan migrate` to create all the tables and the basic structure of the app.

8. run `npm install` to install npm

9. run `gulp` to compile everything

10. LarvelEnso uses "/" as the default route so replace `/home` with `/` in the following files:
    - app/Http/Controllers/Auth/LoginController.php
    - app/Http/Controllers/Auth/RegisterController.php
    - app/Http/Controllers/Auth/ResetPasswordController.php
    - app/Http/Middleware/RedirectIfAuthenticated.php

11. Uncomment `App\Providers\BroadcastServiceProvider::class` from config/app.php file.

12. That was long... I know. At least let's hope it was worth the pain.
Now just go to in you browser to http://project.dev and login with user: admin@login.com and password: password

Now play :)

### Try also

laravel-enso/commentsmanager
laravel-enso/documentsmanager
laravel-enso/tutorialmanager
laravel-enso/localisation

### Contributions

are welcome
