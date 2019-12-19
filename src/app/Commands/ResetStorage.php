<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports'];
    private const TestingFolder = 'testing';
    private const ImportFolder = 'imports';

    protected $signature = 'enso:storage:reset';

    protected $description = 'Run this command after php artisan migrate:fresh to clear the storage';

    public function handle()
    {
        collect(self::Folders)->each(fn ($folder) => (
            collect(Storage::files($folder))
                ->reject(fn($file) => Str::contains($file, '.gitignore'))
                ->each(fn ($file) => Storage::delete($file))
        ));

        collect(Storage::directories(self::ImportFolder))
            ->each(fn ($directory) => Storage::deleteDirectory($directory));

        if (collect(Storage::directories())->contains(self::TestingFolder)) {
            Storage::deleteDirectory(self::TestingFolder);
        }
    }
}
