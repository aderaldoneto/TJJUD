<?php

namespace Tests\Feature;

use App\Filament\Resources\LivroResource;
use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_lista_livros_mostra_registros(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $livro = Livro::factory()->create([
            'titulo' => 'Harry Potter',
        ]);

        $response = $this->get(LivroResource::getUrl());
        $response->assertOk()->assertSee('Harry Potter');
    }

    public function test_varios_autores_para_um_livro(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $autor1 = Autor::factory()->create(['nome' => 'Aderaldo']);
        $autor2 = Autor::factory()->create(['nome' => 'Neto']);
        $livro  = Livro::factory()->create();

        $livro->autores()->sync([$autor1->id, $autor2->id]);

        $this->assertSame(2, $livro->autores()->count());
        $this->assertDatabaseHas('autor_livro', [
            'livro_id' => $livro->id,
            'autor_id' => $autor1->id,
        ]);
        $this->assertDatabaseHas('autor_livro', [
            'livro_id' => $livro->id,
            'autor_id' => $autor2->id,
        ]);
    }

    public function test_varios_assuntos_para_um_livro(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $assunto1 = Assunto::factory()->create(['descricao' => 'Magia']);
        $assunto2 = Assunto::factory()->create(['descricao' => 'Aventura']);
        $livro    = Livro::factory()->create();

        $livro->assuntos()->sync([$assunto1->id, $assunto2->id]);

        $this->assertSame(2, $livro->assuntos()->count());
        $this->assertDatabaseHas('assunto_livro', [
            'livro_id'   => $livro->id,
            'assunto_id' => $assunto1->id,
        ]);
        $this->assertDatabaseHas('assunto_livro', [
            'livro_id'   => $livro->id,
            'assunto_id' => $assunto2->id,
        ]);
    }

    public function test_valor_em_centavos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $livro = Livro::factory()->create(['valor' => 52580]);

        $this->assertSame(52580, $livro->valor);
        $this->assertSame('525,80', $livro->getValorFormatadoAttribute());
    }

    public function test_ano_publicacao_como_int(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $livro = Livro::factory()->create(['ano_publicacao' => 1995]);

        $this->assertSame(1995, $livro->ano_publicacao);
        $this->assertTrue(is_int($livro->getAttribute('ano_publicacao')));
    }

}
