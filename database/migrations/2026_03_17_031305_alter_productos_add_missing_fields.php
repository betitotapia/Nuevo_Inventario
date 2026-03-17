<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'codigo')) {
                $table->string('codigo', 80)->unique()->after('id');
            }

            if (!Schema::hasColumn('productos', 'sku')) {
                $table->string('sku', 80)->nullable()->after('codigo');
            }

            if (!Schema::hasColumn('productos', 'descripcion')) {
                $table->string('descripcion', 255)->after('sku');
            }

            if (!Schema::hasColumn('productos', 'categoria_producto_id')) {
                $table->foreignId('categoria_producto_id')
                    ->nullable()
                    ->after('descripcion')
                    ->constrained('categoria_productos')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('productos', 'unidad_medida_id')) {
                $table->foreignId('unidad_medida_id')
                    ->nullable()
                    ->after('categoria_producto_id')
                    ->constrained('unidad_medidas')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('productos', 'maneja_lote')) {
                $table->boolean('maneja_lote')->default(false)->after('unidad_medida_id');
            }

            if (!Schema::hasColumn('productos', 'maneja_caducidad')) {
                $table->boolean('maneja_caducidad')->default(false)->after('maneja_lote');
            }

            if (!Schema::hasColumn('productos', 'precio_base')) {
                $table->decimal('precio_base', 14, 2)->default(0)->after('maneja_caducidad');
            }

            if (!Schema::hasColumn('productos', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('precio_base');
            }
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'categoria_producto_id')) {
                $table->dropConstrainedForeignId('categoria_producto_id');
            }

            if (Schema::hasColumn('productos', 'unidad_medida_id')) {
                $table->dropConstrainedForeignId('unidad_medida_id');
            }

            $columns = [
                'codigo',
                'sku',
                'descripcion',
                'maneja_lote',
                'maneja_caducidad',
                'precio_base',
                'is_active',
            ];

            $existing = array_filter($columns, fn ($col) => Schema::hasColumn('productos', $col));

            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};