<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use App\Models\Almacen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlmacenController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));

        $almacenes = Almacen::with(['parent', 'responsable', 'children'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('nombre', 'like', "%{$search}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('almacenes.index', compact('almacenes', 'search'));
    }

    public function create(): View
    {
        $padres = Almacen::where('tipo_almacen', 'padre')
            ->where('is_active', true)
            ->orderBy('nombre')
            ->get();

        $usuarios = User::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('almacenes.create', compact('padres', 'usuarios'));
    }

    public function store(StoreAlmacenRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Almacen::create([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'tipo_almacen' => $data['tipo_almacen'],
            'parent_id' => $data['parent_id'] ?? null,
            'responsable_user_id' => $data['responsable_user_id'] ?? null,
            'permite_privado' => $request->boolean('permite_privado'),
            'permite_integral' => $request->boolean('permite_integral'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('almacenes.index')
            ->with('success', 'Almacén creado correctamente.');
    }

    public function show(Almacen $almacene): View
    {
        $almacene->load(['parent', 'responsable', 'children']);

        return view('almacenes.show', ['almacen' => $almacene]);
    }

    public function edit(Almacen $almacene): View
    {
        $padres = Almacen::where('tipo_almacen', 'padre')
            ->where('id', '!=', $almacene->id)
            ->where('is_active', true)
            ->orderBy('nombre')
            ->get();

        $usuarios = User::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('almacenes.edit', [
            'almacen' => $almacene,
            'padres' => $padres,
            'usuarios' => $usuarios,
        ]);
    }

   public function updateAlmacenes(Request $request, User $user): RedirectResponse
        {
            $request->validate([
                'almacenes' => ['nullable', 'array'],
                'almacenes.*.almacen_id' => ['required', 'exists:almacens,id'],
            ]);

            DB::transaction(function () use ($request, $user) {
                $syncData = [];

                foreach ($request->input('almacenes', []) as $item) {
                    if (empty($item['enabled'])) {
                        continue;
                    }

                    $almacenId = (int) $item['almacen_id'];

                    $syncData[$almacenId] = [
                        'puede_consultar' => !empty($item['puede_consultar']),
                        'puede_operar' => !empty($item['puede_operar']),
                    ];
                }

                $user->almacenes()->sync($syncData);
            });

            return redirect()
                ->route('usuarios.show', $user)
                ->with('success', 'Almacenes autorizados actualizados correctamente.');
        }
    public function destroy(Almacen $almacene): RedirectResponse
    {
        if ($almacene->children()->exists()) {
            return back()->with('error', 'No puedes eliminar un almacén que tiene hijos.');
        }

        $almacene->delete();

        return redirect()
            ->route('almacenes.index')
            ->with('success', 'Almacén eliminado correctamente.');
    }

    public function toggleActive(Almacen $almacene): RedirectResponse
    {
        $almacene->update([
            'is_active' => !$almacene->is_active,
        ]);

        return back()->with('success', 'Estatus actualizado correctamente.');
    }
}