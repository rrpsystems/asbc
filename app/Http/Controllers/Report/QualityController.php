<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class QualityController extends Controller
{
    public function analysis()
    {
        return view('report.quality-analysis');
    }
}
