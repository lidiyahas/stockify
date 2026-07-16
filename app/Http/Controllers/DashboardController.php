<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $role = Auth::user()->role;
        $data = $this->service->getDashboardData($role);

        return view('pages.dashboard.admin', $data);
    }
}
