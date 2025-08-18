<?php

namespace Tests\Feature;

use App\Filament\Resources\AutorResource;
use App\Models\Autor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_exibe_lista_de_autores(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Autor::factory()->create(['nome' => 'Aderaldo']);
        $url = AutorResource::getUrl();
        $response = $this->get($url);

        $response->assertOk()->assertSee('Aderaldo');

    }
}
