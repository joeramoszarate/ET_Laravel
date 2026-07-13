<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class HashClientePasswords extends Command
{
    protected $signature = 'cliente:hash-passwords';
    protected $description = 'Hashea todas las contraseñas de cliente que no estén hasheadas con Bcrypt';

    public function handle()
    {
        $this->info('Iniciando hasheo de contraseñas...');

        $clientes = Cliente::all();
        $updated = 0;
        $skipped = 0;

        foreach ($clientes as $cliente) {
            if (!empty($cliente->contraseña)) {
                // Verificar si ya está hasheada (las contraseñas Bcrypt comienzan con $2)
                if (substr($cliente->contraseña, 0, 1) !== '$') {
                    $cliente->contraseña = Hash::make($cliente->contraseña);
                    $cliente->save();
                    $updated++;
                    $this->line("✓ Cliente {$cliente->correo} actualizado");
                } else {
                    $skipped++;
                    $this->line("⊘ Cliente {$cliente->correo} ya hasheado");
                }
            }
        }

        $this->info("\n✅ Proceso completado!");
        $this->info("Contraseñas hasheadas: {$updated}");
        $this->info("Contraseñas ya hasheadas: {$skipped}");
    }
}
