<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $title = 'Dashboard';

        return \view('dashboard.dashboard.index', compact('title'));
    }
}
