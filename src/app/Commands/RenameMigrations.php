<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RenameMigrations extends Command
{
    protected $signature = 'enso:rename-migrations';

    protected $description = 'This command will update migration names';

    public function handle()
    {
        $this->info('Renaming migrations');

        DB::table('migrations')->whereMigration('2017_01_01_144000_create_structure_for_comments_manager')
            ->update(['migration' => '2017_01_01_144000_create_structure_for_comments']);

        DB::table('migrations')->whereMigration('2017_01_01_149750_create_structure_for_how_to_videos')
            ->update(['migration' => '2017_01_01_149750_create_structure_for_how_to']);

        DB::table('migrations')->whereMigration('2017_01_01_134000_create_structure_for_logmanager')
            ->update(['migration' => '2017_01_01_134000_create_structure_for_logs']);

        DB::table('migrations')->whereMigration('2017_01_01_141000_create_structure_for_documents_manager')
            ->update(['migration' => '2017_01_01_141000_create_structure_for_documents']);

        DB::table('migrations')->whereMigration('2017_01_01_136000_create_structure_for_tutorialmanager')
            ->update(['migration' => '2017_01_01_136000_create_structure_for_tutorials']);

        DB::table('migrations')->whereMigration('2017_12_07_132419_create_countries_table')
            ->update(['migration' => '2017_12_07_150000_create_countries_table']);

        DB::table('migrations')->whereMigration('2017_12_07_141731_create_addresses_table')
            ->update(['migration' => '2017_12_07_151000_create_addresses_table']);

        DB::table('migrations')->whereMigration('2018_01_01_100000_create_rejected_imports_table')
            ->update(['migration' => '2017_01_01_145200_create_rejected_imports_table']);

        DB::table('migrations')->whereMigration('2017_12_07_150655_create_structure_for_addresses')
            ->update(['migration' => '2017_12_07_152000_create_structure_for_addresses']);

        DB::table('migrations')->whereMigration('2018_01_29_204255_create_examples_table')
            ->update(['migration' => '2018_01_29_900000_create_examples_table']);

        DB::table('migrations')->whereMigration('2018_07_13_074954_create_discussions_table')
            ->update(['migration' => '2018_07_13_100000_create_discussions_table']);

        DB::table('migrations')->whereMigration('2018_07_13_084954_create_discussion_replies_table')
            ->update(['migration' => '2018_07_13_101000_create_discussion_replies_table']);

        DB::table('migrations')->whereMigration('2018_07_13_084964_create_reactions_table')
            ->update(['migration' => '2018_07_13_102000_create_reactions_table']);

        DB::table('migrations')->whereMigration('2018_07_13_094954_create_structure_for_discussions')
            ->update(['migration' => '2018_07_13_103000_create_structure_for_discussions']);

        DB::table('migrations')->whereMigration('2018_10_23_155453_create_structure_for_company_people')
            ->update(['migration' => '2018_10_07_102000_create_structure_for_companies']);

        DB::table('migrations')->whereMigration('2019_05_19_100000_create_company_person_pivot_table')
            ->update(['migration' => '2018_10_07_103000_create_company_person_pivot_table']);

        $this->info('Migrations renamed successfully');
    }
}
