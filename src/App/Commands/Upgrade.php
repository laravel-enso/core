<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\App\Services\Upgrades\ActionLogsIndex;
use LaravelEnso\Core\App\Services\Upgrades\AddressesMorphKeys;
use LaravelEnso\Core\App\Services\Upgrades\Avatars;
use LaravelEnso\Core\App\Services\Upgrades\Categories;
use LaravelEnso\Core\App\Services\Upgrades\CommentsMorphKeys;
use LaravelEnso\Core\App\Services\Upgrades\Companies;
use LaravelEnso\Core\App\Services\Upgrades\DataImportCleanup;
use LaravelEnso\Core\App\Services\Upgrades\DiscussionsMorphKeys;
use LaravelEnso\Core\App\Services\Upgrades\DocumentsMorphKeys;
use LaravelEnso\Core\App\Services\Upgrades\FilesIndex;
use LaravelEnso\Core\App\Services\Upgrades\FilesMorphKeys;
use LaravelEnso\Core\App\Services\Upgrades\Permissions;
use LaravelEnso\Core\App\Services\Upgrades\UserMorphKey;
use LaravelEnso\Upgrade\App\Services\Upgrade as Service;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso to the lastest v3.9.x';

    private $upgrades = [
        ActionLogsIndex::class,
        Avatars::class,
        Categories::class,
        Companies::class,
        Permissions::class,
        FilesIndex::class,
        UserMorphKey::class,
        FilesMorphKeys::class,
        DocumentsMorphKeys::class,
        CommentsMorphKeys::class,
        AddressesMorphKeys::class,
        DiscussionsMorphKeys::class,
        DataImportCleanup::class,
    ];

    public function handle()
    {
        (new Service($this->upgrades))->handle();
    }
}
