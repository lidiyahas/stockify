<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Jika kolom lama 'reason' masih ada dan 'notes' belum ada, rename via raw SQL
        //    (menghindari kebutuhan package doctrine/dbal untuk renameColumn()).
        if (Schema::hasColumn('stock_transactions', 'reason') && !Schema::hasColumn('stock_transactions', 'notes')) {
            DB::statement("ALTER TABLE stock_transactions CHANGE reason notes TEXT NULL");
        }

        // 2. Jika kolom 'notes' belum ada sama sekali, buat.
        if (!Schema::hasColumn('stock_transactions', 'notes')) {
            Schema::table('stock_transactions', function ($table) {
                $table->text('notes')->nullable();
            });
        }

        // 3. Perbaiki enum status agar sesuai dengan yang dipakai aplikasi.
        DB::statement("
            ALTER TABLE stock_transactions
            MODIFY status ENUM('Pending', 'Diterima', 'Ditolak', 'Dikeluarkan')
            NOT NULL DEFAULT 'Pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE stock_transactions
            MODIFY status ENUM('Pending', 'Disetujui', 'Ditolak')
            NOT NULL DEFAULT 'Pending'
        ");

        if (Schema::hasColumn('stock_transactions', 'notes') && !Schema::hasColumn('stock_transactions', 'reason')) {
            DB::statement("ALTER TABLE stock_transactions CHANGE notes reason TEXT NULL");
        }
    }
};
