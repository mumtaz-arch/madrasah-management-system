<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Additional indexes for query optimization.
     * Uses try-catch to safely ignore "index already exists" errors.
     */
    public function up(): void
    {
        $this->addIndexSafely('payments', 'tanggal_bayar', 'payments_tanggal_bayar_index');

        $this->addCompositeIndexSafely('teacher_journals', ['teacher_id', 'date'], 'tj_teacher_date_index');
        $this->addCompositeIndexSafely('teacher_journals', ['jadwal_id', 'date'], 'tj_jadwal_date_index');

        $this->addCompositeIndexSafely('jadwals', ['guru_id', 'hari'], 'jadwals_guru_hari_index');
        $this->addCompositeIndexSafely('jadwals', ['kelas_id', 'hari'], 'jadwals_kelas_hari_index');

        $this->addIndexSafely('gurus', 'status', 'gurus_status_index');

        if (Schema::hasTable('exam_attempts')) {
            $this->addCompositeIndexSafely('exam_attempts', ['status', 'created_at'], 'ea_status_created_index');
        }
    }

    public function down(): void
    {
        // No-op down to avoid errors on rollback
    }

    private function addIndexSafely(string $table, string $column, string $indexName): void
    {
        try {
            Schema::table($table, function (Blueprint $table) use ($column, $indexName) {
                $table->index($column, $indexName);
            });
        } catch (\Throwable $e) {
            // Index likely exists, ignore
        }
    }

    private function addCompositeIndexSafely(string $table, array $columns, string $indexName): void
    {
        try {
            Schema::table($table, function (Blueprint $table) use ($columns, $indexName) {
                $table->index($columns, $indexName);
            });
        } catch (\Throwable $e) {
            // Index likely exists, ignore
        }
    }
};
