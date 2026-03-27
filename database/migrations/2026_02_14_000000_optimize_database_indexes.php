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
        // Helper closure to check index existence safely
        $indexExists = function ($table, $indexName) {
            $indexes = \Illuminate\Support\Facades\DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        };

        Schema::table('santris', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('santris', 'santris_nama_lengkap_index')) {
                $table->index('nama_lengkap');
            }
            if (!$indexExists('santris', 'santris_status_index')) {
                $table->index('status');
            }
        });

        Schema::table('attendances', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('attendances', 'attendances_status_index')) {
                $table->index('status');
            }
            if (!$indexExists('attendances', 'attendances_tanggal_index')) {
                $table->index('tanggal'); 
            }
        });

        Schema::table('tagihans', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('tagihans', 'tagihans_status_index')) {
                 $table->index('status');
            }
            if (!$indexExists('tagihans', 'tagihans_jatuh_tempo_index')) {
                 $table->index('jatuh_tempo');
            }
        });

        Schema::table('users', function (Blueprint $table) use ($indexExists) {
             if (!$indexExists('users', 'users_role_index')) {
                 $table->index('role');
             }
        });
        
        if (Schema::hasTable('exams')) {
            Schema::table('exams', function (Blueprint $table) use ($indexExists) {
                 if (!$indexExists('exams', 'exams_mulai_index')) {
                     $table->index('mulai');
                 }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $indexExists = function ($table, $indexName) {
            $indexes = \Illuminate\Support\Facades\DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        };

        Schema::table('santris', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('santris', 'santris_nama_lengkap_index')) $table->dropIndex(['nama_lengkap']);
            if ($indexExists('santris', 'santris_status_index')) $table->dropIndex(['status']);
        });

        Schema::table('attendances', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('attendances', 'attendances_status_index')) $table->dropIndex(['status']);
            if ($indexExists('attendances', 'attendances_tanggal_index')) $table->dropIndex(['tanggal']);
        });

        Schema::table('tagihans', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('tagihans', 'tagihans_status_index')) $table->dropIndex(['status']);
            if ($indexExists('tagihans', 'tagihans_jatuh_tempo_index')) $table->dropIndex(['jatuh_tempo']);
        });

        Schema::table('users', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('users', 'users_role_index')) $table->dropIndex(['role']);
        });
        
        if (Schema::hasTable('exams')) {
            Schema::table('exams', function (Blueprint $table) use ($indexExists) {
                if ($indexExists('exams', 'exams_mulai_index')) $table->dropIndex(['mulai']);
            });
        }
    }
};
