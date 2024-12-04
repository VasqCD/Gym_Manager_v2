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
        Schema::create('empleados', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->string('nombre_completo', 100);
            $table->string('dni', 15)->unique();
            $table->string('telefono', 15);
            $table->string('direccion', 255)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('cargo', 50);
            $table->decimal('salario', 10, 2);
            $table->date('fecha_contratacion');
            $table->string('horario_trabajo', 100)->nullable();
            $table->enum('tipo_contrato', ['Tiempo Completo', 'Medio Tiempo', 'Por Horas']);
            $table->string('numero_seguro_social', 20)->nullable();
            $table->string('contacto_emergencia', 100)->nullable();
            $table->string('telefono_emergencia', 15)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Para eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
};
