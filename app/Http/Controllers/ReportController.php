<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $aktivitasPengguna = $this->service->getDashboardActivity(Auth::user()->role);
        return view('pages.reports.index', compact('aktivitasPengguna'));
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
