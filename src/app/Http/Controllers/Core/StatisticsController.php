<?php

namespace LaravelEnso\Core\app\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use LaravelEnso\ActionLogger\ActionHistory;
use LaravelEnso\Core\app\Models\Login;

class StatisticsController extends Controller
{
    public function statistics()
    {
        $startDate = Carbon::parse(request()->start_date)->format('Y-m-d');
        $endDate = Carbon::parse(request()->end_date)->format('Y-m-d');
        $response = [];

        $response['logins'] = Login::where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->count();
        $response['actions'] = ActionHistory::where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->count();

        return response()->json($response)->header('Access-Control-Allow-Origin', 'http://admin.xtelecom.ro');
    }
}
