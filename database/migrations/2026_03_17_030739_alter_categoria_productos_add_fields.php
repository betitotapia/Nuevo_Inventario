<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categoria_productos', function (Blueprint $table) {
            $table->string('nombre', 150)->after('id');
            $table->boolean('is_active')->default(true)->after('nombre');
        });
    }

    public function down(): void
    {
        Schema::table('categoria_productos', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'is_active']);
        });
    }
};