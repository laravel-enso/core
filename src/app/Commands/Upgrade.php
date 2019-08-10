<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\People\app\Models\Person;
use LaravelEnso\Permissions\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from v3.3.* to the latest version';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        $this->addRemindedAt();
    }

    private function addRemindedAt()
    {
        $this->info('Upgrading calendar reminders table');

        if (Schema::hasColumn('reminders', 'reminded_at')) {
            $this->info('The calendar reminders table was already upgraded');

            return $this;
        }

        Schema::table('reminders', function ($table) {
            $table->datetime('reminded_at')->nullable()->after('remind_at')->index();
            $table->index('remind_at');
        });

        $this->info('he calendar reminders table was upgraded successfully');

        return $this;
    }
}
