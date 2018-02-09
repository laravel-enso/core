<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateUserAgentField extends Command
{
    protected $signature = 'enso:update-user-agent';

    protected $description = 'Changes user agent field from string to text in the logins table';

    public function handle()
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->text('user_agent')->change();
        });
    }
}
