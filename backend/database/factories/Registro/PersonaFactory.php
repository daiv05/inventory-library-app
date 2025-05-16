<?php

namespace Database\Factories\Registro;

use App\Models\Registro\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'identificacion' => fake()->unique()->numerify('##########')
        ];
    }
}
