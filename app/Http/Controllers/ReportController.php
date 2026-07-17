<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;

        // Hanya Admin & Manajer Gudang yang boleh akses laporan
        $this->middleware(function ($request, $next) {
            if (! in_array(Auth::user()->role, ['admin', 'manajer_gudang'])) {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        });

        // Laporan aktivitas pengguna khusus Admin
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['activities']);
    }

    public function index()
    {
        $aktivitasPengguna = $this->service->getDashboardActivity(Auth::user()->role);
        return view('pages.reports.index', compact('aktivitasPengguna'));
    }

    public function activities(Request $request)
    {
        $activities = $this->service->getActivityLog(
            20,
            $request->user_id,
            $request->subject_type
        );

        $users = User::all();

        return view('pages.reports.activities', compact('activities', 'users'));
    }

    public function transactions(Request $request)
    {
        $transactions = $this->service->getTransactionReport(
            $request->start_date,
            $request->end_date,
            $request->category_id
        );

        $categories = Category::all();

        return view('pages.reports.transactions', compact('transactions', 'categories'));
    }

    public function stocks(Request $request)
    {
        $products = $this->service->getStockReport(
            $request->category_id,
            $request->start_date,
            $request->end_date
        );

        $categories = Category::all();

        return view('pages.reports.stocks', compact('products', 'categories'));
    }
}
