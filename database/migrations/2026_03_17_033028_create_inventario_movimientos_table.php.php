<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario_movimientos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_movimiento');
            $table->enum('tipo_movimiento', [
                'entrada_ajuste',
                'salida_ajuste',
                'traspaso_salida',
                'traspaso_entrada',
                'salida_remision_privado',
                'salida_servicio_integral',
                'devolucion',
            ]);
            $table->foreignId('almacen_id')->constrained('almacens')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('lote', 80)->nullable();
            $table->date('caducidad')->nullable();
            $table->decimal('cantidad', 14, 3);
            $table->decimal('costo_unitario', 14, 4)->default(0);
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['referencia_tipo', 'referencia_id']);
            $table->index(['almacen_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario_movimientos');
    }
};