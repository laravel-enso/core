<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Region as Model;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Region implements MigratesTable, MigratesPostDataMigration
{
    private array $newRegions = [
        [
            'abbreviation' => 'FPO',
            'name' => 'Fleet Post Office',
            'is_active' => 1,
        ],
        [
            'abbreviation' => 'APO',
            'name' => 'Army Post Office',
            'is_active' => 1,
        ],
        [
            'abbreviation' => 'DPO',
            'name' => 'Diplomatic Post Office',
            'is_active' => 1,
        ],
    ];

    public function isMigrated(): bool
    {
        return Model::whereAbbreviation('APO')->exists();
    }

    public function migrateTable(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->string('abbreviation', 3)->change();
        });
    }

    public function migratePostDataMigration(): void
    {
        (new Collection($this->newRegions))->each(function ($region) {
            Model::create($region + [
                'country_id' => Country::whereName('United States')->first()->id,
            ]);
        });
    }
}
