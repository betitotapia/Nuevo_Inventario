<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unidad_medidas', function (Blueprint $table) {
            $table->string('clave', 20)->after('id');
            $table->string('nombre', 150)->after('clave');
        });
    }

    public function down(): void
    {
        Schema::table('unidad_medidas', function (Blueprint $table) {
            $table->dropColumn(['clave', 'nombre']);
        });
    }
};