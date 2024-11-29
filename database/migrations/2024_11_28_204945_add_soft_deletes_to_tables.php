<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->softDeletes();
    });
    
    Schema::table('rols', function (Blueprint $table) {
        $table->softDeletes();
    });
    
    Schema::table('permisos', function (Blueprint $table) {
        $table->softDeletes();
    });
    
    Schema::table('membresias', function (Blueprint $table) {
        $table->softDeletes();
    });
    
    Schema::table('pagos', function (Blueprint $table) {
        $table->softDeletes();
    });
    
    Schema::table('pagodetalls', function (Blueprint $table) {
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
