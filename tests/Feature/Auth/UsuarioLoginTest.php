<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UsuarioLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_can_login_with_plaintext_password(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF;');

        $user = Usuario::create([
            'id_usuario' => '000000000000000001',
            'correo' => 'demo@explore.test',
            'contraseña' => 'secret123',
            'id_tiprol' => '000000000000000001',
            'nombre' => 'Demo',
            'id_tipdoc' => '0000001',
            'estado' => 'activo',
        ]);

        DB::statement('PRAGMA foreign_keys = ON;');

        $response = $this->post('/login', [
            'email' => $user->correo,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
