<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre_completo' => $this->faker->name,
            'dni' => $this->faker->numerify('#############'),
            'telefono' => $this->faker->numerify('########'),
            'direccion' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-18 years'),
            'genero' => $this->faker->randomElement(['M', 'F']), // Cambiar a M o F según la validación
            'contacto_emergencia' => $this->faker->name,
            'telefono_emergencia' => $this->faker->numerify('########'),
            'condiciones_medicas' => $this->faker->optional()->sentence,
            'fecha_registro' => now(),
            'estado' => false
        ];
    }
}
