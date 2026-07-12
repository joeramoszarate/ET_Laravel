<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ConfiguracionController extends Controller
{
    public function index()
    {
        try {
            if (Schema::hasTable('configuraciones')) {
                $config = Configuracion::first();

                if (!$config) {
                    $config = Configuracion::create([]);
                }

                return view('configuracion', compact('config'));
            }
        } catch (\Exception $e) {
            Log::error('ConfiguracionController@index error: '.$e->getMessage());
        }

        // Si la tabla no existe (migrations no corridas) devolvemos la vista con config null
        $config = null;
        return view('configuracion', compact('config'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('configuraciones')) {
            return redirect()->route('configuracion')->with('error', 'La tabla configuraciones no existe. Ejecuta php artisan migrate.');
        }

        $config = Configuracion::first();

        if (!$config) {
            $config = new Configuracion();
        }

        $validated = $request->validate([
            'nombre_empresa' => 'nullable|string|max:150',
            'email_contacto' => 'nullable|email|max:150',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'moneda' => 'nullable|string|max:50',
            'zona_horaria' => 'nullable|string|max:100',
            'idioma' => 'nullable|string|max:50',

            'notif_email' => 'nullable|boolean',
            'notif_sms' => 'nullable|boolean',
            'confirm_reserva' => 'nullable|boolean',
            'recordatorio_pago' => 'nullable|boolean',
            'emails_marketing' => 'nullable|boolean',

            'stripe_public' => 'nullable|string|max:255',
            'stripe_secret' => 'nullable|string|max:255',
            'stripe_enabled' => 'nullable|boolean',
            'paypal_enabled' => 'nullable|boolean',
        ]);

        // Cast checkbox inputs
        $checkboxes = [
            'notif_email','notif_sms','confirm_reserva','recordatorio_pago','emails_marketing','stripe_enabled','paypal_enabled'
        ];

        foreach ($checkboxes as $c) {
            $validated[$c] = $request->has($c) ? true : false;
        }

        $config->fill($validated);
        $config->save();

        return redirect()->route('configuracion')->with('success', 'Configuración actualizada correctamente.');
    }
}

