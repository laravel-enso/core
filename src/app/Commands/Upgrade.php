<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\People\app\Models\Person;
use LaravelEnso\DataImport\app\Enums\Statuses;
use LaravelEnso\DataImport\app\Models\DataImport;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from 3.3.* to ^3.4';

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
                ->updatePermissions()
                ->updatePeople()
                ->updateContacts()
                ->updateCompanies();
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
            ->update(['status' => Statuses::Finalized]);

        DataImport::get()->each(function ($dataImport) {
            $dataImport->update([
                'successful' => optional($dataImport->summary)->successful,
                'failed' => optional($dataImport->summary)->issues,
            ]);
        });

        Schema::table('data_imports', function (Blueprint $table) {
            $table->dropColumn('summary');
        });

        \DB::statement('ALTER TABLE data_imports MODIFY status TINYINT NOT NULL');

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
            $table->string('name')->after('id');
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
                'description' => 'Upload file for import',
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

    private function updatePeople()
    {
        $this->info('Updating people table');

        if (Schema::hasColumn('people', 'company_id')) {
            $this->info('Table already updated');

            return $this;
        }

        Schema::table('people', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->unsigned()->index()->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('position')->after('birthday')->nullable();
            $table->dropColumn('gender');
        });

        $this->info('Table successfuly updated');

        return $this;
    }

    private function updateContacts()
    {
        $this->info('Updating contacts structure');

        if (! Schema::hasTable('contacts')) {
            $this->info('Structure already updated');
        }

        \DB::table('contacts')->get()
            ->each(function ($contact) {
                Person::whereId($contact->person_id)
                    ->update(collect($contact)->only([
                        'company_id', 'position'
                    ])->toArray());
            });

        Schema::drop('contacts');

        \DB::table('migrations')
            ->whereIn('migration', [
                '2018_10_23_095019_create_contacts_table',
                '2017_01_01_148000_create_structure_for_contacts',
            ])
            ->delete();

        Permission::where(
            'name',
            'LIKE%',
            'administration.companies.contacts.'
        )->delete();

        $this->info('Structure successfuly updated');

        return $this;
    }

    private function updateCompanies()
    {
        $this->info('Updating companies table');

        if (! Schema::hasColumn('companies', 'mandatary_position')) {
            $this->info('Table already updated');

            return $this;
        }

        Company::has('mandatary')
            ->with('mandatary')
            ->get()
            ->each(function ($company) {
                $company->mandatary->update([
                    'company_id' => $company->id,
                    'position' => $company->mandatary_position,
                ]);
            });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('mandatary_position');
        });

        $this->info('Table successfuly updated');

        return $this;
    }
}
