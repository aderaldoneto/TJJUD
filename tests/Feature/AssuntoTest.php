<?php

namespace Tests\Feature;

use App\Filament\Resources\AssuntoResource;
use App\Models\Assunto;
use App\Models\User;
use Filament\Support\Exceptions\Halt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssuntoTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    public function test_exibe_lista_de_assuntos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Assunto::factory()->create(['descricao' => 'Romance']);

        $url = AssuntoResource::getUrl();
        $response = $this->get($url);

        $response->assertOk()->assertSee('Romance');
    }

    public function test_duplicidade_assunto(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $descricao = 'Romance';
        Assunto::create(['descricao' => $descricao]);
        
        $this->expectException(Halt::class);
        Assunto::create(['descricao' => $descricao]); 
    }
}
