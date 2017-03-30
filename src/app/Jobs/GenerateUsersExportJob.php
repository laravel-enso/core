<?php

namespace LaravelEnso\Core\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use LaravelEnso\Core\app\Notifications\UsersExportNotification;
use Maatwebsite\Excel\Facades\Excel;

class GenerateUsersExportJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;
    private $fileName;

    public function __construct($user)
    {
        $this->user = $user;
        $this->fileName = __('Users_Report');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = [];
        $userClass = config('auth.providers.users.model');
        $users = $userClass::with('owner')->with('role')->get();

        foreach ($users as $key => $user) {
            switch ($user->is_active) {

                case 0:
                    $status = __('no');
                    break;
                case 1:
                    $status = __('yes');
                    break;
            }

            $result[] = [

                __('#')            => $key + 1,
                __('First Name')   => $user->first_name,
                __('Last Name')    => $user->last_name,
                __('Phone')        => $user->phone,
                __('Email')        => $user->email,
                __('Role')         => $user->role->name,
                __('Status')       => $status,
                __('Member since') => $user->created_at,
            ];
        }

        Excel::create($this->fileName, function ($excel) use ($result) {
            $excel->sheet('Sheet 1', function ($sheet) use ($result) {
                $sheet->fromArray($result);
                $sheet->setAutoFilter('A1:I1');
                $sheet->freezeFirstRowAndColumn();
                $sheet->setAllBorders('thin');
                $sheet->cells('A1:I1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });
        })->store('xlsx');

        $user = $this->user;
        $file = config('laravel-enso.paths.exports').'/'.$this->fileName.'.xlsx';
        $user->notify(new UsersExportNotification(storage_path('app/'.$file)));
        Storage::delete($file);
    }
}
