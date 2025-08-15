<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ano = (string) $this->faker->numberBetween(1950, (int)date('Y'));

        return [
            'titulo'          => Str::limit($this->faker->unique()->sentence(3), 40, ''),
            'editora'         => Str::limit($this->faker->company(), 40, ''),
            'edicao'          => $this->faker->numberBetween(1, 10),
            'ano_publicacao'  => substr($ano, 0, 4),
            'valor'           => $this->faker->numberBetween( 100, 999_99),
        ];
    }
}
