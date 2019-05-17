# Core

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ba5e8fe6e1dc427590d9bad7721ca037)](https://www.codacy.com/app/laravel-enso/core?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/core&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://github.styleci.io/repos/85807594/shield?branch=master)](https://github.styleci.io/repos/85807594)
[![License](https://poser.pugx.org/laravel-enso/core/license)](https://packagist.org/packages/laravel-enso/core)
[![Total Downloads](https://poser.pugx.org/laravel-enso/core/downloads)](https://packagist.org/packages/laravel-enso/core)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/core/version)](https://packagist.org/packages/laravel-enso/core)

Main requirement & dependency aggregator for [Laravel Enso](https://github.com/laravel-enso/Enso).

This package works exclusively within the [Enso](https://github.com/laravel-enso/Enso) ecosystem.

The front end assets that utilize this api are present in the [ui](https://github.com/enso-ui/ui) package.

For live examples and demos, you may visit [laravel-enso.com](https://www.laravel-enso.com)

## Installation

Comes pre-installed in Enso.

## Features
- core users, roles, permissions structure
- project wide, middleware based, automatic logging of all user actions
- configurable, selective, model event based logging of CRUD (& custom) actions
- integrated avatar functionality with custom & automatic avatar generation
- beautiful charts generation support
- extensible, reusable file management core functionality with sharing capabilities
- powerful, template based form builder with out of the box support for most use cases
and the option for the customization of any input
- model event based history tracking
- middleware based user impersonation support for testing & troubleshooting
- localisation & i18n support
- Laravel log management functionality & interface
- application menus management
- user email & push notifications
- IO operations progress monitoring for data import and export
- extensible, core people functionality
- integrated permissions management
- easy to use caching support
- user roles functionality with friendly interface for role configuration
- customizable, project wide search support
- template based CLI interface for the painless creation of the most needed file structures
- trait based, event driven user tracking for any model state change
- easy to use tutorial functionality for quick human operator training
- model event driven, out of the box versioning support
- aspect consistent ecosystem of front-end VueJS reusable components
- highly powerful, full search, customizable, template based, huge data-set capable, 
front-end back-end integrated data table functionality with support for the export of the entire result-set 
and a great many other features
- customizable, extensible, companies structure
- template based, validation capable, asynchronous capable xlsx data import functionality
 featuring support for big files (the number of rows is limited only by the xlsx format)
- easy to use, searchable, taggable videos support
 
## Optional Features
- customizable, extensible, generic addresses manager plugin
- polymorphic, notification integrated comments functionality
- template based, validation capable, xlsx data import functionality
- intuitive discussions module
- polymorphic, document upload and management functionality

- core teams structure  

## Included packages

[Action Logger](https://github.com/laravel-enso/ActionLogger), 
[Activity Log](https://github.com/laravel-enso/ActivityLog), 
[Avatar Manager](https://github.com/laravel-enso/Avatars) <sup>1</sup>, 
[Charts](https://github.com/laravel-enso/Charts), 
[Companies](https://github.com/laravel-enso/Companies),
[Data Export](https://github.com/laravel-enso/DataExport),
[Data Import](https://github.com/laravel-enso/DataImport), 
[File Manager](https://github.com/laravel-enso/Files), 
[Form Builder](https://github.com/laravel-enso/Forms), 
[Helpers](https://github.com/laravel-enso/Helpers), 
[History Tracker](https://github.com/laravel-enso/HistoryTracker),
[How To Videos](https://github.com/laravel-enso/HowTo),
[Impersonate](https://github.com/laravel-enso/Impersonate), 
[IO](https://github.com/laravel-enso/IO), 
[Localisation](https://github.com/laravel-enso/Localisation), 
[Log Manager](https://github.com/laravel-enso/Logs), 
[Menu Manager](https://github.com/laravel-enso/Menus),
[Multi tenancy](https://github.com/laravel-enso/Multitenancy),
[Notifications](https://github.com/laravel-enso/Notifications), 
[People](https://github.com/laravel-enso/People), 
[Permission Manager](https://github.com/laravel-enso/Permissions), 
[Rememberable](https://github.com/laravel-enso/Rememberable), 
[Role Manager](https://github.com/laravel-enso/Roles), 
[Searchable](https://github.com/laravel-enso/Searchable), 
[Select](https://github.com/laravel-enso/Select), 
[Structure Manager](https://github.com/laravel-enso/Cli), 
[Teams](https://github.com/laravel-enso/Teams), 
[TrackWho](https://github.com/laravel-enso/TrackWho), 
[Tutorial Manager](https://github.com/laravel-enso/Tutorials), 
[Versioning](https://github.com/laravel-enso/Versioning),
[VueDataTable](https://github.com/laravel-enso/VueDataTable), 

## Optional packages

[Addresses Manager](https://github.com/laravel-enso/Addresses), 
[Comments Manager](https://github.com/laravel-enso/Comments),
[Discussions](https://github.com/laravel-enso/Discussions), 
[Documents Manager](https://github.com/laravel-enso/Documents) <sup>1</sup>, 

### Configuration & Details

Be sure to check out the full documentation for this package available at [docs.laravel-enso.com](https://docs.laravel-enso.com/backend/core.html)

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
