<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class TrackWhoUpdate extends Command
{
    const Tables = [
        'activity_logs', 'comments', 'data_exports', 'data_imports', 'documents',
        'discussions', 'discussion_replies', 'reactions', 'files', 'tasks',
    ];

    const Column = 'created_by';

    protected $signature = 'enso:track-who:update';

    protected $description = 'This command will make all `created_by` table columns nullable';

    private $schemaManager;

    public function handle()
    {
        $this->info('The update process has started');

        collect(self::Tables)->each(function ($table) {
            if (Schema::hasTable($table)) {
                $this->update($table);
            }
        });

        $this->info('The update process was successful.');
    }

    private function update($table)
    {
        Schema::table($table, function ($table) {
            $table->integer(self::Column)
                ->unsigned()
                ->nullable()
                ->change();
        });
        $this->info('Column: '.self::Column.' on table: '.$table.' is now nullable');
    }
}
