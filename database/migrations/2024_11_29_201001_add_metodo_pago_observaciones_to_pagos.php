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
        Schema::table('pagos', function (Blueprint $table) {
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia'])
                ->default('efectivo')
                ->after('total');
            $table->text('observaciones')
                ->nullable()
                ->after('metodo_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['metodo_pago', 'observaciones']);
        });
    }
};
