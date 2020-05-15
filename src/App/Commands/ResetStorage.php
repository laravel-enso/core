<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports'];
    private const TestingFolder = 'testing';
    private const ImportFolder = 'imports';

    protected $signature = 'enso:storage:reset';

    protected $description = 'Run this after php artisan migrate:fresh to clear the storage';

    public function handle()
    {
        (new Collection(self::Folders))
            ->each(fn ($folder) => (new Collection(Storage::files($folder)))
                ->reject(fn ($file) => strpos($file, '.gitignore') !== false)
                ->each(fn ($file) => Storage::delete($file)));

        (new Collection(Storage::directories(self::ImportFolder)))
            ->each(fn ($directory) => Storage::deleteDirectory($directory));

        if (in_array(self::TestingFolder, Storage::directories())) {
            Storage::deleteDirectory(self::TestingFolder);
        }
    }
}
