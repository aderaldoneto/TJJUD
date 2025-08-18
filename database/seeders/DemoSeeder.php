<?php

namespace Database\Seeders;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {   
        $autores  = Autor::factory(15)->create();

        if (!Assunto::query()->exists()) {
            $assuntos = Assunto::factory(10)->create();
        } else {
            $assuntos = Assunto::all();
        }

        Livro::factory(30)->create()->each(function (Livro $livro) use ($autores, $assuntos) {
            $autorIds = $autores->random(rand(1, 3))->pluck('id')->all();
            $assuntoIds = $assuntos->random(rand(1, 5))->pluck('id')->all();

            $livro->autores()->syncWithoutDetaching($autorIds);
            $livro->assuntos()->syncWithoutDetaching($assuntoIds);
        });
    }
}
