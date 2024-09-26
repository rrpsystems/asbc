<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class CdrController extends Controller
{
    public function index()
    {

        return view('report.cdr');

    }
}
