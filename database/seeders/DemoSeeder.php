<?php

namespace Database\Seeders;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user     = User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com', 
            'password' => bcrypt('password'),
        ]);
        $autores  = Autor::factory(15)->create();
        $assuntos = Assunto::factory(10)->create();

        Livro::factory(30)->create()->each(function (Livro $livro) use ($autores, $assuntos) {
            $autorIds = $autores->random(rand(1, 3))->pluck('id')->all();
            $assuntoIds = $assuntos->random(rand(1, 5))->pluck('id')->all();

            $livro->autores()->syncWithoutDetaching($autorIds);
            $livro->assuntos()->syncWithoutDetaching($assuntoIds);
        });
    }
}
