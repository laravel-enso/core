<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports'];
    private const TestingFolder = 'testing';
    private const ImportFolder = 'imports';

    protected $signature = 'enso:storage:reset';

    protected $description = 'Run this command after php artisan migrate:fresh to clear the storage';

    public function handle()
    {
        collect(self::Folders)->each(function ($folder) {
            collect(Storage::files($folder))->reject(function ($file) {
                return strpos($file, '.gitignore') !== false;
            })->each(function ($file) {
                Storage::delete($file);
            });
        });

        collect(Storage::directories(self::ImportFolder))->each(function ($directory) {
            Storage::deleteDirectory($directory);
        });

        if (collect(Storage::directories())->contains(self::TestingFolder)) {
            Storage::deleteDirectory(self::TestingFolder);
        }
    }
}
