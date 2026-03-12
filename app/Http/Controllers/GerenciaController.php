<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Gerencia;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Gerencia::with('direccion.unidadNegocio')->withCount('areas');

        if ($request->filled('direccion_id')) {
            $query->where('direccion_id', $request->direccion_id);
        }

        $gerencias = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.gerencias.index', compact('gerencias', 'direcciones'));
    }

    public function create()
    {
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.gerencias.create', compact('direcciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'direccion_id' => ['required', 'exists:direcciones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        Gerencia::create($validated);

        return redirect()->route('gerencias.index')
            ->with('status', __('Gerencia creada correctamente.'));
    }

    public function edit(Gerencia $gerencia)
    {
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.gerencias.edit', compact('gerencia', 'direcciones'));
    }

    public function update(Request $request, Gerencia $gerencia)
    {
        $validated = $request->validate([
            'direccion_id' => ['required', 'exists:direcciones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $gerencia->update($validated);

        return redirect()->route('gerencias.index')
            ->with('status', __('Gerencia actualizada correctamente.'));
    }

    public function destroy(Gerencia $gerencia)
    {
        $gerencia->delete();

        return redirect()->route('gerencias.index')
            ->with('status', __('Gerencia eliminada correctamente.'));
    }
}
