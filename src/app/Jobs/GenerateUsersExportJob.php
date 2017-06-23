<?php

namespace LaravelEnso\Core\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\Core\app\Notifications\UsersExportNotification;

class GenerateUsersExportJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $fileName;
    private $data;

    public function __construct($user)
    {
        $this->user = $user;
        $this->fileName = __('Users_Report');
        $this->data = collect();
    }

    public function handle()
    {
        $this->setData();
        $this->create();
        $this->send();
    }

    private function setData()
    {
        $statuses = new IsActiveEnum();

        User::with(['owner', 'role'])->get()->each(function ($user, $index) use ($statuses) {
            $this->data->push([
                __('#')            => $index + 1,
                __('First Name')   => $user->first_name,
                __('Last Name')    => $user->last_name,
                __('Phone')        => $user->phone,
                __('Email')        => $user->email,
                __('Role')         => $user->role->name,
                __('Status')       => $statuses->getValueByKey($user->is_active),
                __('Member since') => $user->created_at,
            ]);
        });
    }

    private function create()
    {
        \Excel::create($this->fileName, function ($excel) {
            $excel->sheet('Sheet 1', function ($sheet) {
                $sheet->fromArray($this->data->toArray());
                $sheet->setAutoFilter('A1:H1');
                $sheet->freezeFirstRowAndColumn();
                $sheet->setAllBorders('thin');
                $sheet->cells('A1:H1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });
        })->store('xlsx');
    }

    private function send()
    {
        $file = config('laravel-enso.paths.exports').'/'.$this->fileName.'.xlsx';
        $this->user->notify(new UsersExportNotification(storage_path('app/'.$file)));
        \Storage::delete($file);
    }
}
