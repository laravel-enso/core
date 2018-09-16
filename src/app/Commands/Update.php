<?php

namespace LaravelEnso\Core\app\Commands;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Update extends Command
{
    protected $signature = 'enso:update';

    protected $description = 'This command will update Enso for 2.10.0';

    public function handle()
    {
        auth()->loginUsingId(User::first()->id);

        \Artisan::call('enso:filemanager:upgrade');

        $this->info('The update process has started');
        $this->update();
        $this->info('The update process was successful.');
    }

    private function update()
    {
        \DB::transaction(function () {
            $this->updateDocuments();
            $this->updateAddresses();

            $this->updateHowToVideos();
        });
    }

    private function updateDocuments()
    {
        if (!Schema::hasTable('documents')) {
            return;
        }

        if (!Schema::hasColumn('documents', 'name')) {
            $this->info('The update for documents was already performed');

            return;
        }

        $this->info('Updating documents');

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });

        $this->info('Documents were successfully updated');
    }

    private function updateAddresses()
    {
        if (!Schema::hasTable('addresses')) {
            return;
        }

        $this->info('Updating addresses');

        Schema::table('addresses', function (Blueprint $table) {
            $table->text('obs')->change();
        });

        $this->info('Addressses were successfully updated');
    }

    private function updateHowToVideos()
    {
        if (!Schema::hasTable('how_to_videos')) {
            return;
        }

        $this->info('Updating how-to videos');

        Schema::table('how_to_videos', function (Blueprint $table) {
            $table->text('description')->change();
        });

        $this->info('How-to videos were successfully updated');
    }
}
