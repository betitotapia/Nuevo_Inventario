<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('existencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almacen_id')->constrained('almacens')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('lote', 80)->nullable();
            $table->date('caducidad')->nullable();
            $table->decimal('cantidad', 14, 3)->default(0);
            $table->decimal('costo_promedio', 14, 4)->default(0);
            $table->timestamps();

            $table->index(['almacen_id', 'producto_id']);
            $table->unique(['almacen_id', 'producto_id', 'lote', 'caducidad'], 'existencias_unique_lote');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('existencias');
    }
};