<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Existencia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExistenciaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));
        $almacenId = $request->get('almacen_id');

        $existencias = Existencia::with(['almacen', 'producto'])
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('producto', function ($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when(!empty($almacenId), function ($query) use ($almacenId) {
                $query->where('almacen_id', $almacenId);
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $almacenes = Almacen::where('is_active', true)->orderBy('nombre')->get();

        return view('inventario.existencias', compact('existencias', 'almacenes', 'search', 'almacenId'));
    }
}