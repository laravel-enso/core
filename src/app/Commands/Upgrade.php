<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\Localisation\app\Models\Language;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        $this->upgradeLanguagesTable();
    }

    private function upgradeLanguagesTable()
    {
        if (Schema::hasColumn('languages', 'is_rtl')) {
            $this->info('Languages table is already upgraded');

            return $this;
        }

        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_rtl')->after('flag')->nullable();
        });

        Language::where('name', '<>', 'ar')->update(['is_rtl' => false]);

        Language::whereName('ar')->update(['is_rtl' => true]);

        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_rtl')->nullable(false)->change();
        });

        $this->info('Languages table was successfuly upgraded');

        return $this;
    }
}
