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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor');
            $table->decimal('tasa_interes');
            $table->decimal('valor_prestamo');
            $table->integer('numero_cuotas');
            $table->date('fecha_prestamo');
            $table->foreignId('asociados_id')->constrained('asociados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
