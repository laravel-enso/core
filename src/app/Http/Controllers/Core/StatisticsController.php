<?php

namespace LaravelEnso\Core\App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use LaravelEnso\ActionLogger\ActionsHistory;
use LaravelEnso\Core\App\Models\Login;

class StatisticsController extends Controller
{
    public function statistics()
    {
        $start_date = Carbon::parse(request()->start_date)->format('Y-m-d');
        $end_date   = Carbon::parse(request()->end_date)->format('Y-m-d');
        $response   = [];

        $response['logins']  = Login::where('created_at', '>', $start_date)->where('created_at', '<', $end_date)->count();
        $response['actions'] = ActionsHistory::where('created_at', '>', $start_date)->where('created_at', '<', $end_date)->count();

        return response()->json($response)->header('Access-Control-Allow-Origin', 'http://admin.xtelecom.ro');
    }
}
