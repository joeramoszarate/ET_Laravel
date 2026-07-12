<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa')->nullable();
            $table->string('email_contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('moneda')->nullable();
            $table->string('zona_horaria')->nullable();
            $table->string('idioma')->nullable();

            $table->boolean('notif_email')->default(true);
            $table->boolean('notif_sms')->default(false);
            $table->boolean('confirm_reserva')->default(true);
            $table->boolean('recordatorio_pago')->default(true);
            $table->boolean('emails_marketing')->default(false);

            $table->string('stripe_public')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->boolean('stripe_enabled')->default(false);
            $table->boolean('paypal_enabled')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
};
