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
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 150);
            $table->enum('tipo_almacen', ['padre', 'hijo', 'tecnico', 'general'])->default('general');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('responsable_user_id')->nullable();
            $table->boolean('permite_privado')->default(false);
            $table->boolean('permite_integral')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('almacens')->nullOnDelete();
            $table->foreign('responsable_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacens');
    }
};
