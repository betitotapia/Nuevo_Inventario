<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));
        $tipo = trim((string) $request->get('tipo'));

        $clientes = Cliente::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('nombre_comercial', 'like', "%{$search}%")
                        ->orWhere('razon_social', 'like', "%{$search}%")
                        ->orWhere('rfc', 'like', "%{$search}%")
                        ->orWhere('contacto_principal', 'like', "%{$search}%");
                });
            })
            ->when(in_array($tipo, ['privado', 'integral', 'mixto'], true), function ($query) use ($tipo) {
                $query->where('tipo_cliente', $tipo);
            })
            ->orderBy('nombre_comercial')
            ->paginate(15)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'search', 'tipo'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente): View
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    public function toggleActive(Cliente $cliente): RedirectResponse
    {
        $cliente->update([
            'is_active' => !$cliente->is_active,
        ]);

        return back()->with('success', 'Estatus actualizado correctamente.');
    }
}