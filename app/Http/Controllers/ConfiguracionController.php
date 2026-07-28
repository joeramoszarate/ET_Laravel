<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $config = Schema::hasTable('configuraciones')
            ? (Configuracion::first() ?? Configuracion::create([]))
            : null;
        return view('configuracion', compact('config'));
    }

    public function mipagina()
    {
        $config = Schema::hasTable('configuraciones')
            ? (Configuracion::first() ?? Configuracion::create([]))
            : null;
        return view('mi_pagina_Web', compact('config'));
    }

    public function updateWeb(Request $request)
    {
        $config = Configuracion::first() ?? new Configuracion();

        $fields = [
            'hero_titulo','hero_subtitulo','slogan',
            'seccion_nosotros_titulo','seccion_nosotros_texto',
            'banner1_titulo','banner1_link',
            'banner2_titulo','banner2_link',
            'color_primario','color_secundario',
            'whatsapp','facebook_url','instagram_url',
        ];

        foreach ($fields as $f) {
            if ($request->has($f)) $config->$f = $request->$f;
        }

        // Subida de imágenes
        $imageFields = [
            'logo'               => 'logo_url',
            'hero_imagen'        => 'hero_imagen_url',
            'banner1_imagen'     => 'banner1_imagen',
            'banner2_imagen'     => 'banner2_imagen',
            'nosotros_imagen'    => 'seccion_nosotros_imagen',
        ];

        foreach ($imageFields as $input => $column) {
            if ($request->hasFile($input)) {
                $path = $request->file($input)->store('web', 'public');
                $config->$column = asset('storage/' . $path);
            }
        }

        $config->save();
        return redirect()->route('mipagina')->with('success', 'Cambios guardados correctamente.');
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('configuraciones')) {
            return redirect()->route('configuracion')->with('error', 'Ejecuta php artisan migrate.');
        }

        $config = Configuracion::first() ?? new Configuracion();
        $tab = $request->input('_tab', 'general');

        if ($tab === 'seguridad') {
            $request->validate([
                'current_password' => 'required|string',
                'new_password'     => 'required|string|min:8|confirmed',
            ]);
            $user = auth()->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'La contraseña actual no es correcta.')->withInput();
            }
            $user->update(['password' => Hash::make($request->new_password)]);
            return redirect()->route('configuracion')->with('success', 'Contraseña actualizada.');
        }

        $validated = $request->validate([
            'nombre_empresa'     => 'nullable|string|max:150',
            'email_contacto'     => 'nullable|email|max:150',
            'telefono'           => 'nullable|string|max:30',
            'direccion'          => 'nullable|string|max:255',
            'descripcion'        => 'nullable|string',
            'moneda'             => 'nullable|string|max:50',
            'zona_horaria'       => 'nullable|string|max:100',
            'idioma'             => 'nullable|string|max:50',
            'notif_email'        => 'nullable|boolean',
            'notif_sms'          => 'nullable|boolean',
            'confirm_reserva'    => 'nullable|boolean',
            'recordatorio_pago'  => 'nullable|boolean',
            'emails_marketing'   => 'nullable|boolean',
            'stripe_public'      => 'nullable|string|max:255',
            'stripe_secret'      => 'nullable|string|max:255',
            'stripe_enabled'     => 'nullable|boolean',
            'paypal_enabled'     => 'nullable|boolean',
        ]);

        foreach (['notif_email','notif_sms','confirm_reserva','recordatorio_pago','emails_marketing','stripe_enabled','paypal_enabled'] as $c) {
            $validated[$c] = $request->has($c);
        }

        $config->fill($validated)->save();
        return redirect()->route('configuracion')->with('success', 'Configuración actualizada.');
    }
}
