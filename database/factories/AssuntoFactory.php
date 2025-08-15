<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assunto>
 */
class AssuntoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $listaAssunto = [
            'Drama', 'Romance', 'Terror', 'Ficção Científica', 'Suspense', 
            'Tecnologia', 'História', 'Ciência', 'Educação','Policial',
        ];


        return [
            'descricao' => $this->faker->unique()->randomElement($listaAssunto),
        ];
    }
}
