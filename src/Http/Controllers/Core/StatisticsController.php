<?php

namespace LaravelEnso\Core\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;
use LaravelEnso\ActionLogger\ActionsHistory;
use LaravelEnso\Core\Models\Login;

class StatisticsController extends Controller
{
    public function statistics()
    {
        $start_date = Date::parse(request()->start_date)->format('Y-m-d');
        $end_date = Date::parse(request()->end_date)->format('Y-m-d');
        $response = [];

        $response['logins'] = Login::where('created_at', '>', $start_date)->where('created_at', '<', $end_date)->count();
        $response['actions'] = ActionsHistory::where('created_at', '>', $start_date)->where('created_at', '<', $end_date)->count();

        return response()->json($response)->header('Access-Control-Allow-Origin', 'http://admin.xtelecom.ro');
    }
}
