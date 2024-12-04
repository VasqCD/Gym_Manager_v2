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
        if (!Schema::hasColumn('pagodetalls', 'impuesto')) {
            Schema::table('pagodetalls', function (Blueprint $table) {
                $table->decimal('impuesto', 5, 2)->default(0);
                $table->decimal('descuento', 5, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagodetalls', function (Blueprint $table) {
            $table->dropColumn('impuesto');
            $table->dropColumn('descuento');
        });
    }
};
