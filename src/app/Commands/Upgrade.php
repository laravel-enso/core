<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\DataImport\app\Enums\Statuses;
use LaravelEnso\DataImport\app\Models\DataImport;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core to 3.4.x';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        \DB::transaction(function () {
            $this->updateImportTable()
                ->updateExportTable()
                ->updatePermissions();
        });
    }

    private function updateImportTable()
    {
        $this->info('Updating data_imports table');

        if (Schema::hasColumn('data_imports', 'successful')) {
            $this->info('Table already updated');

            return $this;
        }

        Schema::table('data_imports', function (Blueprint $table) {
            $table->integer('successful')->nullable()->after('type');
            $table->integer('failed')->nullable()->after('successful');
            $table->tinyInteger('status')->after('failed')->nullable();

            $table->integer('created_by')->after('status')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')
                ->on('users');
        });

        DataImport::whereNull('status')
            ->update(['status' => Statuses::Processed]);

        DataImport::get()->each(function ($dataImport) {
            $dataImport->update([
                'successful' => optional($dataImport->summary)->successful,
                'failed' => optional($dataImport->summary)->issues,
            ]);
        });

        Schema::table('data_imports', function (Blueprint $table) {
            $table->tinyInteger('status')->change();
            $table->dropColumn('summary');
        });

        $this->info('Table successfuly updated');

        return $this;
    }

    private function updateExportTable()
    {
        $this->info('Updating data_exports table');

        if (Schema::hasColumn('data_exports', 'entries')) {
            $this->info('Table already updated');

            return $this;
        }

        Schema::table('data_exports', function (Blueprint $table) {
            $table->string('type')->after('name');
            $table->integer('entries')->nullable()->after('name');
            $table->tinyInteger('status')->after('entries')->nullable();

            $table->integer('created_by')->after('status')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')
                ->on('users');
        });

        $this->info('Table successfuly updated');

        return $this;
    }

    private function updatePermissions()
    {
        $this->info('Updating data_imports permissions');

        if (Permission::whereName('import.store')->first()) {
            $this->info('The permissions were already updated');

            return $this;
        }

        Permission::whereName('import.run')
            ->update([
                'name' => 'import.store',
                'description' => 'Upload file for import'
            ]);

        Permission::whereName('import.getSummary')
            ->update(['name' => 'import.summary']);

        Permission::whereName('import.getTemplate')
            ->update(['name' => 'import.template']);

        Permission::whereName('import.summary')
            ->update([
                'name' => 'import.downloadRejected',
                'description' => 'Download rejected summary for import',
            ]);

        $this->info('Permissions successfuly updated');

        return $this;
    }
}
