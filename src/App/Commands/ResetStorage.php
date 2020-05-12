<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports', 'pictures'];
    private const TestingFolder = 'testing';
    private const ImportFolder = 'imports';

    protected $signature = 'enso:storage:reset';

    protected $description = 'Run this after php artisan migrate:fresh to clear the storage';

    public function handle()
    {
        (new Collection(self::Folders))
            ->each(fn ($directory) => $this->reset($directory));

        if (in_array(self::TestingFolder, Storage::directories())) {
            Storage::deleteDirectory(self::TestingFolder);
        }

        Artisan::call('storage:link');
    }

    private function reset($directory)
    {
        if (Storage::has($directory)) {
            Storage::deleteDirectory($directory);
        }

        Storage::makeDirectory($directory);
    }
}
