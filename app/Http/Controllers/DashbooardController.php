<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbooardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }
}
