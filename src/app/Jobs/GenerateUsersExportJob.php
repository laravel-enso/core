<?php

namespace LaravelEnso\Core\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelEnso\Core\app\Exports\UsersReport;
use LaravelEnso\Core\app\Notifications\UsersExportNotification;

class GenerateUsersExportJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $fileName;
    private $fullPathFile;
    private $exporter;

    public function __construct($user)
    {
        $this->user = $user;
        $this->fileName = __('Users_Report');
        $this->fullPathFile = config('laravel-enso.paths.exports').'/'.$this->fileName.'.xlsx';
        $this->exporter = new UsersReport($this->fileName);
    }

    public function handle()
    {
        $this->exporter->run();
        $this->sendReport();
    }

    private function sendReport()
    {
        $this->user->notify(new UsersExportNotification(storage_path('app/'.$this->fullPathFile)));
    }

    private function cleanUp()
    {
        \Storage::delete($this->fullPathFile);
    }
}
