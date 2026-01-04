<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function analysis()
    {
        return view('report.route-analysis');
    }
}
