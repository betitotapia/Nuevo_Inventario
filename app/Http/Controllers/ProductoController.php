<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));
        $estado = trim((string) $request->get('estado'));

        $productos = Producto::with(['categoria', 'unidad'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%");
                });
            })
            ->when($estado === 'activos', function ($query) {
                $query->where('is_active', true);
            })
            ->when($estado === 'inactivos', function ($query) {
                $query->where('is_active', false);
            })
            ->orderBy('descripcion')
            ->paginate(15)
            ->withQueryString();

        return view('productos.index', compact('productos', 'search', 'estado'));
    }

    public function create(): View
    {
        $categorias = CategoriaProducto::where('is_active', true)->orderBy('nombre')->get();
        $unidades = UnidadMedida::orderBy('nombre')->get();

        return view('productos.create', compact('categorias', 'unidades'));
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['maneja_lote'] = $request->boolean('maneja_lote');
        $data['maneja_caducidad'] = $request->boolean('maneja_caducidad');
        $data['is_active'] = $request->boolean('is_active', true);

        Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto): View
    {
        $producto->load(['categoria', 'unidad']);

        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto): View
    {
        $categorias = CategoriaProducto::where('is_active', true)->orderBy('nombre')->get();
        $unidades = UnidadMedida::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias', 'unidades'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $data = $request->validated();

        $data['maneja_lote'] = $request->boolean('maneja_lote');
        $data['maneja_caducidad'] = $request->boolean('maneja_caducidad');
        $data['is_active'] = $request->boolean('is_active');

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function toggleActive(Producto $producto): RedirectResponse
    {
        $producto->update([
            'is_active' => !$producto->is_active,
        ]);

        return back()->with('success', 'Estatus actualizado correctamente.');
    }
}