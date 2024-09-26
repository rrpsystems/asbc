<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function index(){

        return view('config.carrier');

    }
}
