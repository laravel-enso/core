<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;

class DBRenameReserved extends Command
{
    protected $signature = 'enso:db-rename-reserved';

    protected $description = 'This command will rename all the columns that have reserved names: `order` => `order_index`, `default` => `is_default`';

    public function handle()
    {
        if (\Schema::hasColumn('menus', 'order')) {
            \Schema::table('menus', function (Blueprint $table) {
                $table->renameColumn('order', 'order_index');
            });

            $this->info('In "menus" table the column "order" was renamed to "order_index"');
        }

        if (\Schema::hasColumn('permissions', 'default')) {
            \Schema::table('permissions', function (Blueprint $table) {
                $table->renameColumn('default', 'is_default');
            });

            $this->info('In "permissions" table the column "default" was renamed to "is_default"');
        }

        if (\Schema::hasColumn('tutorials', 'order')) {
            \Schema::table('tutorials', function (Blueprint $table) {
                $table->renameColumn('order', 'order_index');
            });

            $this->info('In "tutorials" table the column "order" was renamed to "order_index"');
        }

        $this->info('Everything is up to date. Be sure to update all the structure migrations / db seeders accordingly');
    }
}
