<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index()
    {

        return view('report.invoice');

    }
}
