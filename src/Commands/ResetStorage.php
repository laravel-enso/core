<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResetStorage extends Command
{
    private const Folders = ['avatars', 'exports', 'files', 'howToVideos', 'imports', 'pictures'];
    private const TestingFolder = 'testing';

    protected $signature = 'enso:storage:reset {--include=}';

    protected $description = 'Run this after php artisan migrate:fresh to clear the storage';

    public function handle()
    {
        $include = Str::of($this->option('include'))->explode(',');

        Collection::wrap(self::Folders)->concat($include)->filter()
            ->each(fn ($directory) => $this->reset($directory));

        if (in_array(self::TestingFolder, Storage::directories())) {
            Storage::deleteDirectory(self::TestingFolder);
        }
    }

    private function reset($directory): void
    {
        if (Storage::has($directory)) {
            Collection::wrap(Storage::files($directory))
                ->each(fn ($file) => Storage::delete($file));

            return;
        }

        Storage::makeDirectory($directory);
    }
}
