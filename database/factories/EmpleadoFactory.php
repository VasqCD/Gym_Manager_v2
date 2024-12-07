<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    public function definition()
    {
        $tiposContrato = ['Tiempo Completo', 'Medio Tiempo', 'Por Horas'];
        $cargos = ['Entrenador', 'Recepcionista', 'Limpieza', 'Nutricionista', 'Administrador'];
        
        return [
            'nombre_completo' => $this->faker->name,
            'dni' => $this->faker->unique()->numerify('#############'),
            'telefono' => $this->faker->numerify('########'),
            'direccion' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'cargo' => $this->faker->randomElement($cargos),
            'salario' => $this->faker->randomFloat(2, 8000, 25000),
            'fecha_contratacion' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'horario_trabajo' => $this->faker->randomElement(['Matutino', 'Vespertino', 'Mixto']),
            'tipo_contrato' => $this->faker->randomElement($tiposContrato),
            'numero_seguro_social' => $this->faker->numerify('##########'),
            'contacto_emergencia' => $this->faker->name,
            'telefono_emergencia' => $this->faker->numerify('########'),
            'activo' => true
        ];
    }
}