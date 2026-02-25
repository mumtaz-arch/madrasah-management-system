<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add file upload columns one at a time for SQLite compatibility
        $columnsToAdd = [
            'file_kk' => 'string',
            'file_akta_kelahiran' => 'string',
            'file_ijazah_skl' => 'string',
            'file_ktp_ortu' => 'string',
            'file_pas_foto' => 'string',
            'no_hp' => 'string',
            'nisn' => 'string',
            'tahun_lulus' => 'string',
            'nama_ayah' => 'string',
            'nama_ibu' => 'string',
            'pekerjaan_ayah' => 'string',
            'pekerjaan_ibu' => 'string',
        ];

        foreach ($columnsToAdd as $column => $type) {
            if (!Schema::hasColumn('ppdb_registrations', $column)) {
                Schema::table('ppdb_registrations', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'file_kk', 'file_akta_kelahiran', 'file_ijazah_skl', 'file_ktp_ortu', 'file_pas_foto',
            'no_hp', 'nisn', 'tahun_lulus', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu'
        ];
        
        foreach ($columns as $column) {
            if (Schema::hasColumn('ppdb_registrations', $column)) {
                Schema::table('ppdb_registrations', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
