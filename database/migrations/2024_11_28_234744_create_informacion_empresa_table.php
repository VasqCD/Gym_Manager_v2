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
        Schema::create('informacion_empresa', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->string('nombre', 100);
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('rtn', 50)->nullable(); // Registro Tributario Nacional
            $table->string('logo', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('horario', 100)->nullable();
            $table->string('redes_sociales', 255)->nullable();
            $table->timestamps();
            $table->softDeletes(); // Consistente con otras tablas del proyecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_empresa');
    }
};
