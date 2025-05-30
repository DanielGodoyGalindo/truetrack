<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade'); // si se borra el cliente, borrar el envio
            $table->foreignId('reparto_id')->nullable()->constrained('repartos')->onDelete('set null'); // si se borra un reparto, que se ponga el campo como nulo en la tabla de envios
            $table->string('destinatario');
            $table->string('email', 150);
            $table->enum('estado', ['pendiente', 'en reparto', 'entregado', 'no entregado', 'anulado']);
            $table->unsignedInteger('bultos');
            $table->decimal('kilos', 6, 2)->unsigned();
            $table->string('informacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
