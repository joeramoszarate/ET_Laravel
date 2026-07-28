<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\TipoDocumento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_can_view_profile_page(): void
    {
        $tipoDocumento = TipoDocumento::create([
            'id_tipdoc' => 'TD001',
            'descripcion' => 'DNI',
        ]);

        $cliente = Cliente::create([
            'id_cliente' => 'C000001',
            'nombre' => 'Juan',
            'apellidos' => 'Pérez',
            'nro_documento' => '12345678',
            'correo' => 'juan@example.com',
            'contraseña' => '123456',
            'nacionalidad' => 'Peruano',
            'id_tipdoc' => $tipoDocumento->id_tipdoc,
            'telefono' => '999888777',
        ]);

        $this->withSession([
            'cliente_id' => $cliente->id_cliente,
            'cliente_nombre' => $cliente->nombre,
        ])->get(route('cliente.perfil'))
            ->assertOk()
            ->assertSee('Mi perfil');
    }

    public function test_cliente_can_update_personal_information(): void
    {
        $tipoDocumento = TipoDocumento::create([
            'id_tipdoc' => 'TD002',
            'descripcion' => 'Pasaporte',
        ]);

        $cliente = Cliente::create([
            'id_cliente' => 'C000002',
            'nombre' => 'Ana',
            'apellidos' => 'Torres',
            'nro_documento' => '87654321',
            'correo' => 'ana@example.com',
            'contraseña' => '123456',
            'nacionalidad' => 'Ecuatoriana',
            'id_tipdoc' => $tipoDocumento->id_tipdoc,
            'telefono' => '987654321',
        ]);

        $this->withSession([
            'cliente_id' => $cliente->id_cliente,
            'cliente_nombre' => $cliente->nombre,
        ])->post(route('cliente.perfil.actualizar'), [
            'nombre' => 'Ana María',
            'apellidos' => 'Torres Rojas',
            'correo' => 'ana.nueva@example.com',
            'telefono' => '911111111',
            'nacionalidad' => 'Peruana',
            'descripcion' => 'Amante de los viajes',
        ])->assertRedirect();

        $this->assertDatabaseHas('cliente', [
            'id_cliente' => $cliente->id_cliente,
            'nombre' => 'Ana María',
            'correo' => 'ana.nueva@example.com',
            'descripcion' => 'Amante de los viajes',
        ]);
    }
}
