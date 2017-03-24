<?php

namespace LaravelEnso\Core\App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\App\Jobs\GenerateUsersExportJob;

class ExcelController extends Controller
{
    public function getUsers()
    {
        $this->dispatch(new GenerateUsersExportJob(request()->user()));

        return __('The requested report was started.  It can take a few minutes before you have it in your inbox');
    }
}
