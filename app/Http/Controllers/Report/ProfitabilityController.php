<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class ProfitabilityController extends Controller
{
    public function index()
    {
        return view('report.profitability');
    }
}
