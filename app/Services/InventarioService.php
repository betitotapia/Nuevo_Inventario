<?php

namespace App\Services;

use App\Models\Existencia;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InventarioService
{
    public function registrarMovimiento(array $data): InventarioMovimiento
    {
        return DB::transaction(function () use ($data) {
            return match ($data['tipo_movimiento']) {
                'entrada_ajuste', 'traspaso_entrada', 'devolucion' => $this->entrada($data),
                'salida_ajuste', 'traspaso_salida', 'salida_remision_privado', 'salida_servicio_integral' => $this->salida($data),
                default => throw new RuntimeException('Tipo de movimiento no soportado.'),
            };
        });
    }

    protected function entrada(array $data): InventarioMovimiento
    {
        $producto = Producto::findOrFail($data['producto_id']);

        $lote = $producto->maneja_lote ? ($data['lote'] ?? null) : null;
        $caducidad = $producto->maneja_caducidad ? ($data['caducidad'] ?? null) : null;
        $ubicacion = $data['ubicacion'] ?? null;

        if ($producto->maneja_lote && empty($lote)) {
            throw new RuntimeException('El producto requiere lote.');
        }

        if ($producto->maneja_caducidad && empty($caducidad)) {
            throw new RuntimeException('El producto requiere fecha de caducidad.');
        }

        $existencia = Existencia::query()
            ->where('almacen_id', $data['almacen_id'])
            ->where('producto_id', $data['producto_id'])
            ->where('lote', $lote)
            ->where('caducidad', $caducidad)
            ->lockForUpdate()
            ->first();

        if (!$existencia) {
            $existencia = Existencia::create([
                'almacen_id' => $data['almacen_id'],
                'producto_id' => $data['producto_id'],
                'lote' => $lote,
                'caducidad' => $caducidad,
                'ubicacion' => $ubicacion,
                'cantidad' => 0,
                'costo_promedio' => 0,
            ]);
        }

        $cantidad = (float) $data['cantidad'];
        $costoUnitario = (float) ($data['costo_unitario'] ?? 0);

        $existencia->cantidad = (float) $existencia->cantidad + $cantidad;

        if (!empty($ubicacion)) {
            $existencia->ubicacion = $ubicacion;
        }

        if ($costoUnitario > 0) {
            $existencia->costo_promedio = $costoUnitario;
        }

        $existencia->save();

        return InventarioMovimiento::create([
            'fecha_movimiento' => $data['fecha_movimiento'] ?? now(),
            'tipo_movimiento' => $data['tipo_movimiento'],
            'almacen_id' => $data['almacen_id'],
            'producto_id' => $data['producto_id'],
            'lote' => $lote,
            'caducidad' => $caducidad,
            'ubicacion' => $ubicacion,
            'cantidad' => $cantidad,
            'costo_unitario' => $costoUnitario,
            'referencia_tipo' => $data['referencia_tipo'] ?? null,
            'referencia_id' => $data['referencia_id'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'user_id' => $data['user_id'],
        ]);
    }

    protected function salida(array $data): InventarioMovimiento
    {
        $producto = Producto::findOrFail($data['producto_id']);

        $lote = $producto->maneja_lote ? ($data['lote'] ?? null) : null;
        $caducidad = $producto->maneja_caducidad ? ($data['caducidad'] ?? null) : null;
        $ubicacion = $data['ubicacion'] ?? null;

        if ($producto->maneja_lote && empty($lote)) {
            throw new RuntimeException('El producto requiere lote.');
        }

        if ($producto->maneja_caducidad && empty($caducidad)) {
            throw new RuntimeException('El producto requiere fecha de caducidad.');
        }

        $existencia = Existencia::query()
            ->where('almacen_id', $data['almacen_id'])
            ->where('producto_id', $data['producto_id'])
            ->where('lote', $lote)
            ->where('caducidad', $caducidad)
            ->lockForUpdate()
            ->first();

        if (!$existencia) {
            throw new RuntimeException('No existe stock para el producto seleccionado.');
        }

        $cantidad = (float) $data['cantidad'];
        $stockActual = (float) $existencia->cantidad;

        if ($stockActual < $cantidad) {
            throw new RuntimeException('No hay existencia suficiente para realizar la salida.');
        }

        if (!empty($ubicacion)) {
            $existencia->ubicacion = $ubicacion;
        }

        $existencia->cantidad = $stockActual - $cantidad;
        $existencia->save();

        return InventarioMovimiento::create([
            'fecha_movimiento' => $data['fecha_movimiento'] ?? now(),
            'tipo_movimiento' => $data['tipo_movimiento'],
            'almacen_id' => $data['almacen_id'],
            'producto_id' => $data['producto_id'],
            'lote' => $lote,
            'caducidad' => $caducidad,
            'ubicacion' => $ubicacion ?: $existencia->ubicacion,
            'cantidad' => $cantidad,
            'costo_unitario' => (float) ($data['costo_unitario'] ?? $existencia->costo_promedio ?? 0),
            'referencia_tipo' => $data['referencia_tipo'] ?? null,
            'referencia_id' => $data['referencia_id'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'user_id' => $data['user_id'],
        ]);
    }
}