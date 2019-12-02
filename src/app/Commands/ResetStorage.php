<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports'];
    private const TestingFolder = 'testing';

    protected $signature = 'enso:reset-storage';

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

        if (collect(Storage::directories())->contains(self::TestingFolder)) {
            Storage::deleteDirectory(self::TestingFolder);
        }
    }
}
