<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardRepository
{
    public function getCounts(): array
    {
        $counts = [
            'products' => $this->safeCount('products'),
            'categories' => $this->safeCount('categories'),
            'suppliers' => $this->safeCount('suppliers'),
            'users' => $this->safeCount('users'),
            'transactions' => $this->safeCount('transactions'),
        ];

        return $counts;
    }

    public function getTotalStock(): int
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'stock')) {
            return (int) DB::table('products')->sum('stock');
        }
        return 0;
    }

    public function getLowStockProducts(int $limit = 5)
    {
        if (! Schema::hasTable('products')) return [];

        $query = DB::table('products')
            ->select('id', 'name', 'stock')
            ->orderBy('stock', 'asc')
            ->limit($limit)
            ->get();

        return $query->toArray();
    }

    public function getStockPerCategory()
    {
        if (! Schema::hasTable('products') || ! Schema::hasTable('categories')) return [];

        // Asumsi relasi products.category_id -> categories.id
        $rows = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.id', 'categories.name', DB::raw('COALESCE(SUM(products.stock), 0) as total_stock'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return $rows->map(fn($r) => ['category' => $r->name, 'stock' => (int)$r->total_stock])->toArray();
    }

    public function getMonthlyTransactions(int $months = 12)
    {
        if (! Schema::hasTable('transactions')) return [];

        $start = now()->subMonths($months - 1)->startOfMonth();

        $rows = DB::table('transactions')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"), DB::raw('COUNT(*) as count'), DB::raw('COALESCE(SUM(amount),0) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // Normalize to include months with 0
        $result = [];
        for ($i = 0; $i < $months; $i++) {
            $m = $start->copy()->addMonths($i)->format('Y-m');
            $result[$m] = ['month' => $m, 'count' => 0, 'total' => 0];
        }

        foreach ($rows as $r) {
            $result[$r->ym] = ['month' => $r->ym, 'count' => (int)$r->count, 'total' => (float)$r->total];
        }

        return array_values($result);
    }

    public function getRecentActivities(int $limit = 10)
    {
        // Jika kamu punya tabel logs/activity, gunakan itu. Jika tidak, kembalikan array kosong.
        if (! Schema::hasTable('activity_logs')) {
            // alternatif: ambil dari laravel logs atau tabel lain
            return [];
        }

        return DB::table('activity_logs')
            ->select('id', 'user_id', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    private function safeCount(string $table): int
    {
        if (! Schema::hasTable($table)) return 0;
        return (int) DB::table($table)->count();
    }
}