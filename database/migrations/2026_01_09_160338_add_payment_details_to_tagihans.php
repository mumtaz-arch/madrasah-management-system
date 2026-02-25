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
        if (!Schema::hasColumn('tagihans', 'metode_bayar')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->string('metode_bayar')->nullable()->after('status');
            });
        }
        if (!Schema::hasColumn('tagihans', 'bukti_bayar')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->string('bukti_bayar')->nullable()->after('metode_bayar');
            });
        }
        if (!Schema::hasColumn('tagihans', 'tanggal_bayar')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->date('tanggal_bayar')->nullable()->after('bukti_bayar');
            });
        }
        if (!Schema::hasColumn('tagihans', 'nominal_bayar')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->decimal('nominal_bayar', 15, 2)->nullable()->after('tanggal_bayar');
            });
        }
        if (!Schema::hasColumn('tagihans', 'verified_by')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('nominal_bayar');
            });
        }
        if (!Schema::hasColumn('tagihans', 'verified_at')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            });
        }
        if (!Schema::hasColumn('tagihans', 'catatan_pembayaran')) {
            Schema::table('tagihans', function (Blueprint $table) {
                $table->text('catatan_pembayaran')->nullable()->after('verified_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            //
        });
    }
};
