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
        Schema::create('pagodetalls', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pago_id');
            $table->unsignedBigInteger('membresia_id');
            $table->integer('cantidad');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 5, 2)->default(0);  // agregar la columna impuesto
            $table->decimal('descuento', 5, 2)->default(0);  // agregar la columna descuento
    
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
            $table->foreign('membresia_id')->references('id')->on('membresias')->onDelete('cascade');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
