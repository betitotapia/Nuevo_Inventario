<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAjusteInventarioRequest;
use App\Models\Almacen;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use App\Services\InventarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class AjusteInventarioController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {
    }

    public function index(Request $request): View
    {
        $movimientos = InventarioMovimiento::with(['almacen', 'producto', 'user'])
            ->whereIn('tipo_movimiento', ['entrada_ajuste', 'salida_ajuste'])
            ->orderByDesc('fecha_movimiento')
            ->paginate(20);

        return view('inventario.ajustes.index', compact('movimientos'));
    }

    public function create(): View
    {
        $almacenes = Almacen::where('is_active', true)->orderBy('nombre')->get();
        $productos = Producto::where('is_active', true)->orderBy('descripcion')->get();

        return view('inventario.ajustes.create', compact('almacenes', 'productos'));
    }

    public function store(StoreAjusteInventarioRequest $request): RedirectResponse
    {
        try {
            $this->inventarioService->registrarMovimiento([
                ...$request->validated(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->route('inventario.ajustes.index')
                ->with('success', 'Ajuste de inventario registrado correctamente.');
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}