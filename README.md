# Laravel Enso Core
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ba5e8fe6e1dc427590d9bad7721ca037)](https://www.codacy.com/app/laravel-enso/Core?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/Core&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://styleci.io/repos/85807594/shield?branch=master)](https://styleci.io/repos/85807594)
[![Total Downloads](https://poser.pugx.org/laravel-enso/core/downloads)](https://packagist.org/packages/laravel-enso/core)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/core/version)](https://packagist.org/packages/laravel-enso/core)

Main requirement & dependency aggregator for [laravel-enso/Enso](https://github.com/laravel-enso/Enso).

### Includes
- [`laravel-enso/actionlogger`](https://github.com/laravel-enso/ActionLogger)
- [`laravel-enso/avatarmanager`](https://github.com/laravel-enso/AvatarManager)
- [`laravel-enso/charts`](https://github.com/laravel-enso/Charts)
- [`laravel-enso/datatable`](https://github.com/laravel-enso/DataTable)
- [`laravel-enso/filemanager`](https://github.com/laravel-enso/FileManager)
- [`laravel-enso/helpers`](https://github.com/laravel-enso/Helpers)
- [`laravel-enso/historytracker`](https://github.com/laravel-enso/HistoryTracker)
- [`laravel-enso/impersonate`](https://github.com/laravel-enso/Impersonate)
- [`laravel-enso/localisation`](https://github.com/laravel-enso/Localisation)
- [`laravel-enso/logmanager`](https://github.com/laravel-enso/LogManager)
- [`laravel-enso/menumanager`](https://github.com/laravel-enso/MenuManager)
- [`laravel-enso/permissionmanager`](https://github.com/laravel-enso/PermissionManager)
- [`laravel-enso/rememberable`](https://github.com/laravel-enso/Rememberable)
- [`laravel-enso/rolemanager`](https://github.com/laravel-enso/RoleManager)
- [`laravel-enso/select`](https://github.com/laravel-enso/Select)
- [`laravel-enso/structuremanager`](https://github.com/laravel-enso/StructureManager)
- [`laravel-enso/trackwho`](https://github.com/laravel-enso/TrackWho)
- [`laravel-enso/tutorialmanager`](https://github.com/laravel-enso/TutorialManager)

### Can be added
- Notifications
- Documents Manager
- Comments Manager
- Data Import

### Installation

#### Easy way
- clone the [laravel-enso/Enso](https://github.com/laravel-enso/Enso) repository and follow the 3 steps to quickly get a 
working install

#### Hard way
- Include the `AuthCoreServiceProvider`, `CoreServiceProvider` and `EventServiceProvider` providers in the `config/app.php` file
- Publish configuration and resources `php artisan vendor:publish`
- Run the migrations `php artisan migrate`
- double check all configuration files

### Can publish
- `php artisan vendor:publish --tag=core-config` - the configuration files
- `php artisan vendor:publish --tag=core-preferences` - the json preferences file
- `php artisan vendor:publish --tag=core-lang` - the default lang files
- `php artisan vendor:publish --tag=core-storage` - the storage folders
- `php artisan vendor:publish --tag=update` - a common alias for when wanting to update the VueJS components, 
once a newer version is released.

### Contributions

are welcome
