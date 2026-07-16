use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE stock_transactions
            MODIFY date DATETIME
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE stock_transactions
            MODIFY date DATE
        ");
    }
};