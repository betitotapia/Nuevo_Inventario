<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 40)->unique();
            $table->dateTime('fecha_traspaso');
            $table->foreignId('almacen_origen_id')->constrained('almacens')->cascadeOnDelete();
            $table->foreignId('almacen_destino_id')->constrained('almacens')->cascadeOnDelete();
            $table->enum('estatus', ['borrador', 'aplicado', 'cancelado'])->default('aplicado');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traspasos');
    }
};