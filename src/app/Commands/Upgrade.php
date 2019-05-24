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

    protected $description = 'This command will upgrade Core from v3.2.* to v.3.3.*';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        $this->addOrganizeMenus()
            ->upgradeCompanyPerson()
            ->upgradePolimorphics()
            ->dropRegion();
    }

    private function addOrganizeMenus()
    {
        $this->info('Adding organize menu action');

        if (Permission::whereName('system.menus.organize')->first() !== null) {
            $this->info('Organize menu action was already added');

            return $this;
        }

        $this->info('Adding organize menus');

        $permission = Permission::create([
            'name' => 'system.menus.organize',
            'description' => 'Organize menus',
            'type' => 1,
            'is_default' => false,
        ]);

        $permission->roles()->sync(Roles::keys());

        $this->info('Organize menus action was successfully added');

        return $this;
    }

    private function upgradeCompanyPerson()
    {
        $this->info('Upgrading company person relationship');

        if (! Schema::hasColumn('people', 'company_id')) {
            $this->info('The company person relationship was already upgraded');

            return $this;
        }

        DB::table('companies')
            ->get()
            ->each(function ($company) {
                $people = DB::table('people')
                    ->whereCompanyId($company->id)
                    ->get();

                if ($people->isNotEmpty()) {
                    $this->syncCompanyPerson($company, $people);
                }
            });

        Schema::table('companies', function ($table) {
            $table->dropForeign(['mandatary_id']);
            try {
                $table->dropIndex(['mandatary_id']);
            } catch (\Exception $e) {
                echo 'Error droppiung mandatary_id index, safe to ignore'.PHP_EOL;
            }
            $table->dropColumn('mandatary_id');
        });

        Schema::table('people', function ($table) {
            $table->dropForeign(['company_id']);
            try {
                $table->dropIndex(['company_id']);
            } catch (\Exception $e) {
                echo 'Error droppiung company_id index, safe to ignore'.PHP_EOL;
            }
            $table->dropColumn('company_id');
            $table->dropColumn('position');
        });

        $this->info('The Company Person relation was upgraded successfully and the data was migrated');

        return $this;
    }

    private function syncCompanyPerson($company, $people)
    {
        $mandataryId = $company->mandatary_id ?? $people->first()->id;

        $people->each(function ($person) use ($company, $mandataryId) {
            Person::find($person->id)
                ->companies()
                ->sync([$company->id => [
                    'is_main' => true,
                    'is_mandatary' => $mandataryId === $person->id,
                    'position' => $person->position,
                ]]);
        });
    }

    private function upgradePolimorphics()
    {
        DB::table('files')->whereAttachableType('LaravelEnso\AvatarManager\app\Models\Avatar')
            ->update(['attachable_type' => 'LaravelEnso\Avatars\app\Models\Avatar']);

        DB::table('files')->whereAttachableType('LaravelEnso\FileManager\app\Models\Upload')
            ->update(['attachable_type' => 'LaravelEnso\Files\app\Models\Upload']);

        DB::table('files')->whereAttachableType('LaravelEnso\DocumentsManager\app\Models\Document')
            ->update(['attachable_type' => 'LaravelEnso\Documents\app\Models\Document']);

        DB::table('files')->whereAttachableType('LaravelEnso\HowToVideos\app\Models\Poster')
            ->update(['attachable_type' => 'LaravelEnso\HowTo\app\Models\Poster']);

        DB::table('files')->whereAttachableType('LaravelEnso\HowToVideos\app\Models\Video')
            ->update(['attachable_type' => 'LaravelEnso\HowTo\app\Models\Video']);

        return $this;
    }

    private function dropRegion()
    {
        if (Schema::hasColumn('localities', 'region')) {
            Schema::table('localities', function ($table) {
                $table->dropColumn('region');
            });
        }
    }
}
