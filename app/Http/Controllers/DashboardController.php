<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $data = $this->service->getDashboardData($role, $request->start_date, $request->end_date);

        return view('pages.dashboard.admin', $data);
    }
}
