<?php

namespace LaravelEnso\Core\app\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Jobs\GenerateUsersExportJob;

class ExcelController extends Controller
{
    public function getUsers()
    {
        $this->dispatch(new GenerateUsersExportJob(request()->user()));

        return __('The requested report was started.  It can take a few minutes before you have it in your inbox');
    }
}
