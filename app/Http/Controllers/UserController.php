<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Almacen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));

        $users = User::with(['roles', 'almacen'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('clave_remision', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('usuarios.index', compact('users', 'search'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        $almacenes = Almacen::where('is_active', true)->orderBy('nombre')->get();

        return view('usuarios.create', compact('roles', 'almacenes'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'tipo_operacion' => $data['tipo_operacion'],
            'clave_remision' => $data['clave_remision'] ?: null,
            'almacen_id' => $data['almacen_id'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user): View
    {
        $user->load(['roles', 'almacen']);

        return view('usuarios.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        $almacenes = Almacen::where('is_active', true)->orderBy('nombre')->get();

        return view('usuarios.edit', compact('user', 'roles', 'almacenes'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'tipo_operacion' => $data['tipo_operacion'],
            'clave_remision' => $data['clave_remision'] ?: null,
            'almacen_id' => $data['almacen_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if (!empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $user->update($payload);
        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleActive(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return back()->with('success', 'Estatus actualizado correctamente.');
    }

    public function almacenes(User $user): View
{
    $user->load(['almacen', 'almacenes']);

    $almacenes = Almacen::where('is_active', true)
        ->orderBy('nombre')
        ->get();

    $asignados = $user->almacenes->keyBy('id');

    return view('usuarios.almacenes', compact('user', 'almacenes', 'asignados'));
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
   

        
}