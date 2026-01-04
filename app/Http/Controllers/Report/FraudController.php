<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class FraudController extends Controller
{
    public function detection()
    {
        return view('report.fraud-detection');
    }
}
