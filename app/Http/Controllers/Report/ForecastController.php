<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class ForecastController extends Controller
{
    public function revenue()
    {
        return view('report.revenue-forecast');
    }
}
