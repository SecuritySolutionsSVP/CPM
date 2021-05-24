<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    function logView() {
        return view('logs-view');
    }
}
