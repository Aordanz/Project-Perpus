<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Menambahkan kolom-kolom yang dibutuhkan Laravel Auth ke tbluser
     * TANPA menghapus atau mengubah kolom yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('tbluser', function (Blueprint $table) {
            // Kolom email untuk login modern (opsional, karena sistem lama pakai username)
            if (!Schema::hasColumn('tbluser', 'email')) {
                $table->string('email')->nullable()->unique()->after('username');
            }

            // Kolom role untuk sistem hak akses Laravel ('pustakawan' atau 'anggota')
            if (!Schema::hasColumn('tbluser', 'role')) {
                $table->string('role', 50)->default('anggota')->after('status_administrator');
            }

            // Kolom remember_token untuk fitur "Ingat Saya" saat login
            if (!Schema::hasColumn('tbluser', 'remember_token')) {
                $table->rememberToken()->after('role');
            }

            // Kolom email_verified_at untuk verifikasi email (fitur opsional di masa depan)
            if (!Schema::hasColumn('tbluser', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            // Kolom updated_at standar Laravel untuk pelacakan perubahan data
            if (!Schema::hasColumn('tbluser', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('tglinput');
            }
        });

        // Otomatis mengisi kolom 'role' berdasarkan status_administrator yang sudah ada
        // status_administrator = 1 → pustakawan (admin)
        // status_administrator = 0 atau lainnya → anggota
        DB::table('tbluser')
            ->where('status_administrator', 1)
            ->update(['role' => 'pustakawan']);

        DB::table('tbluser')
            ->where('status_administrator', '!=', 1)
            ->update(['role' => 'anggota']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbluser', function (Blueprint $table) {
            $columns = ['email', 'email_verified_at', 'role', 'remember_token', 'updated_at'];
            $existing = [];
            foreach ($columns as $col) {
                if (Schema::hasColumn('tbluser', $col)) {
                    $existing[] = $col;
                }
            }
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};
