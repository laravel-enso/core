<?php

namespace LaravelEnso\Core\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use LaravelEnso\Core\App\Models\User;
use Laravel\Enso\App\Notifications\UsersExportNotification;
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

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = [];
        $users = User::with('owner')->with('role')->get();

        foreach ($users as $key => $user) {
            switch ($user->is_active) {

                case 0:
                    $status = trans('export.no');
                    break;
                case 1:
                    $status = trans('export.yes');
                    break;
            }

            $result[] = [

                'Nr. Crt'      => $key + 1,
                'Prenume'      => $user->first_name,
                'Nume'         => $user->last_name,
                'Telefon'      => $user->phone,
                'Email'        => $user->email,
                'CNP'          => $user->nin,
                'Rol'          => $user->role->name,
                'Status'       => $status,
                'Data Crearii' => $user->created_at,
            ];
        }

        Excel::create('Raport Users', function ($excel) use ($result) {
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

        $user->notify(new UsersExportNotification());

        Storage::delete('exports/Raport Users.xlsx');
    }
}
