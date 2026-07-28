<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Tour;
use App\Models\Destino;
use App\Models\CategoriaTour;
use App\Models\TipoDocumento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteReservaTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_logeado_puede_ver_formulario_reserva(): void
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

        $destino = Destino::create([
            'id_destino' => 'D001',
            'nombre' => 'Puerto Pizarro',
            'descripcion' => 'Hermoso puerto',
            'categoria' => 'Playa',
            'imagen_url' => 'http://example.com/img.jpg',
        ]);

        $categoria = CategoriaTour::create([
            'id_catto' => 'CAT001',
            'descripcion' => 'Tours de aventura',
        ]);

        $tour = Tour::create([
            'id_tour' => 'T001',
            'nombre_tour' => 'Tour Islas Ballestas',
            'descripcion' => 'Visita las islas ballestas',
            'duracion_dias' => 3,
            'precio' => 220.00,
            'estado' => 'activo',
            'id_destino' => $destino->id_destino,
            'id_catto' => $categoria->id_catto,
            'ubicacion_exacta' => 'Puerto Pizarro, Tumbes',
            'imagen_url' => 'http://example.com/tour.jpg',
        ]);

        $this->withSession([
            'cliente_id' => $cliente->id_cliente,
            'cliente_nombre' => $cliente->nombre,
        ])->get(route('cliente.tours.reserva', ['id_tour' => $tour->id_tour]))
            ->assertOk()
            ->assertSee('Reservar');
    }

    public function test_cliente_no_logeado_es_redirigido_al_login(): void
    {
        $destino = Destino::create([
            'id_destino' => 'D002',
            'nombre' => 'Pampas de Tumbes',
            'descripcion' => 'Tours en pampas',
            'categoria' => 'Naturaleza',
            'imagen_url' => 'http://example.com/img.jpg',
        ]);

        $categoria = CategoriaTour::create([
            'id_catto' => 'CAT002',
            'descripcion' => 'Tours culturales',
        ]);

        $tour = Tour::create([
            'id_tour' => 'T002',
            'nombre_tour' => 'Tour Cultural',
            'descripcion' => 'Tour cultural',
            'duracion_dias' => 2,
            'precio' => 150.00,
            'estado' => 'activo',
            'id_destino' => $destino->id_destino,
            'id_catto' => $categoria->id_catto,
            'ubicacion_exacta' => 'Centro de Tumbes',
            'imagen_url' => 'http://example.com/tour2.jpg',
        ]);

        $this->get(route('cliente.tours.reserva', ['id_tour' => $tour->id_tour]))
            ->assertRedirect(route('cliente.login'));
    }

    public function test_cliente_puede_guardar_reserva(): void
    {
        $tipoDocumento = TipoDocumento::create([
            'id_tipdoc' => 'TD003',
            'descripcion' => 'Pasaporte',
        ]);

        $cliente = Cliente::create([
            'id_cliente' => 'C000003',
            'nombre' => 'Ana',
            'apellidos' => 'García',
            'nro_documento' => '87654321',
            'correo' => 'ana@example.com',
            'contraseña' => '123456',
            'id_tipdoc' => $tipoDocumento->id_tipdoc,
        ]);

        $destino = Destino::create([
            'id_destino' => 'D003',
            'nombre' => 'Manglares',
            'descripcion' => 'Tours en manglares',
            'categoria' => 'Aventura',
            'imagen_url' => 'http://example.com/img.jpg',
        ]);

        $categoria = CategoriaTour::create([
            'id_catto' => 'CAT003',
            'descripcion' => 'Tours eco',
        ]);

        $tour = Tour::create([
            'id_tour' => 'T003',
            'nombre_tour' => 'Tour Manglares',
            'descripcion' => 'Tour en manglares',
            'duracion_dias' => 1,
            'precio' => 100.00,
            'estado' => 'activo',
            'id_destino' => $destino->id_destino,
            'id_catto' => $categoria->id_catto,
            'ubicacion_exacta' => 'Manglares del Sur',
            'imagen_url' => 'http://example.com/tour3.jpg',
        ]);

        $this->withSession([
            'cliente_id' => $cliente->id_cliente,
            'cliente_nombre' => $cliente->nombre,
        ])->post(route('cliente.tours.reserva.store', $tour->id_tour), [
            'adultos' => 2,
            'ninos' => 1,
            'descuentos_noche' => 0,
            'tipo_recepcion' => 'individual',
            'canal' => 'directo',
            'fecha_inicio' => '2026-08-10',
            'fecha_fin' => '2026-08-11',
            'hora_llegada' => '14:00',
            'hora_salida' => '11:00',
            'observaciones' => 'Test observación',
        ])->assertRedirect(route('cliente.inicio'));

        $this->assertDatabaseHas('reserva', [
            'id_cliente' => $cliente->id_cliente,
            'estado' => 'P',
        ]);
    }
}
