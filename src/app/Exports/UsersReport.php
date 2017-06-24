<?php

namespace LaravelEnso\Core\app\Exports;

use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\Core\app\Models\User;

class UsersReport
{
    private $fileName;
    private $data;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->data = collect();
    }

    public function run()
    {
    	$this->setData();
    	$this->createReport();
    }

    private function setData()
    {
        $statuses = new IsActiveEnum();

        User::with(['owner', 'role'])->get()->each(function ($user, $index) use ($statuses) {
            $this->data->push([
                __('#') => $index + 1,
                __('First Name') => $user->first_name,
                __('Last Name') => $user->last_name,
                __('Phone') => $user->phone,
                __('Email') => $user->email,
                __('Role') => $user->role->name,
                __('Status') => $statuses->getValueByKey($user->is_active),
                __('Member since') => $user->created_at,
            ]);
        });
    }

    private function createReport()
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
}