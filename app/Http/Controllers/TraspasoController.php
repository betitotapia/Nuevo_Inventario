<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTraspasoRequest;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\Traspaso;
use App\Services\InventarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class TraspasoController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {
    }

    public function index(): View
    {
        $traspasos = Traspaso::with(['origen', 'destino', 'creador'])
            ->orderByDesc('fecha_traspaso')
            ->paginate(20);

        return view('inventario.traspasos.index', compact('traspasos'));
    }

    public function create(): View
    {
        $almacenes = Almacen::where('is_active', true)->orderBy('nombre')->get();
        $productos = Producto::where('is_active', true)->orderBy('descripcion')->get();

        return view('inventario.traspasos.create', compact('almacenes', 'productos'));
    }

    public function store(StoreTraspasoRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $folio = 'TRS-' . now()->format('YmdHis');

                $traspaso = Traspaso::create([
                    'folio' => $folio,
                    'fecha_traspaso' => now(),
                    'almacen_origen_id' => $request->almacen_origen_id,
                    'almacen_destino_id' => $request->almacen_destino_id,
                    'estatus' => 'aplicado',
                    'observaciones' => $request->observaciones,
                    'created_by' => auth()->id(),
                ]);

                foreach ($request->items as $item) {
                    $this->inventarioService->registrarMovimiento([
                        'fecha_movimiento' => now(),
                        'tipo_movimiento' => 'traspaso_salida',
                        'almacen_id' => $request->almacen_origen_id,
                        'producto_id' => $item['producto_id'],
                        'lote' => $item['lote'] ?? null,
                        'caducidad' => $item['caducidad'] ?? null,
                        'ubicacion' => $item['ubicacion_origen'] ?? null,
                        'cantidad' => $item['cantidad'],
                        'costo_unitario' => $item['costo_unitario'] ?? 0,
                        'referencia_tipo' => 'traspaso',
                        'referencia_id' => $traspaso->id,
                        'observaciones' => $request->observaciones,
                        'user_id' => auth()->id(),
                    ]);

                    $this->inventarioService->registrarMovimiento([
                        'fecha_movimiento' => now(),
                        'tipo_movimiento' => 'traspaso_entrada',
                        'almacen_id' => $request->almacen_destino_id,
                        'producto_id' => $item['producto_id'],
                        'lote' => $item['lote'] ?? null,
                        'caducidad' => $item['caducidad'] ?? null,
                        'ubicacion' => $item['ubicacion_destino'] ?? null,
                        'cantidad' => $item['cantidad'],
                        'costo_unitario' => $item['costo_unitario'] ?? 0,
                        'referencia_tipo' => 'traspaso',
                        'referencia_id' => $traspaso->id,
                        'observaciones' => $request->observaciones,
                        'user_id' => auth()->id(),
                    ]);

                    $traspaso->detalles()->create([
                        'producto_id' => $item['producto_id'],
                        'lote' => $item['lote'] ?? null,
                        'caducidad' => $item['caducidad'] ?? null,
                        'ubicacion_origen' => $item['ubicacion_origen'] ?? null,
                        'ubicacion_destino' => $item['ubicacion_destino'] ?? null,
                        'cantidad' => $item['cantidad'],
                        'costo_unitario' => $item['costo_unitario'] ?? 0,
                    ]);
                }
            });

            return redirect()
                ->route('inventario.traspasos.index')
                ->with('success', 'Traspaso aplicado correctamente.');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Traspaso $traspaso): View
    {
        $traspaso->load(['origen', 'destino', 'creador', 'detalles.producto']);

        return view('inventario.traspasos.show', compact('traspaso'));
    }
}