<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisiones = Division::withCount('unidadesNegocio')
            ->orderBy('nombre')
            ->paginate(10);

        return view('catalogos.divisiones.index', compact('divisiones'));
    }

    public function create()
    {
        return view('catalogos.divisiones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        Division::create($validated);

        return redirect()->route('divisiones.index')
            ->with('status', __('División creada correctamente.'));
    }

    public function edit(Division $divisione)
    {
        return view('catalogos.divisiones.edit', compact('divisione'));
    }

    public function update(Request $request, Division $divisione)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $divisione->update($validated);

        return redirect()->route('divisiones.index')
            ->with('status', __('División actualizada correctamente.'));
    }

    public function destroy(Division $divisione)
    {
        $divisione->delete();

        return redirect()->route('divisiones.index')
            ->with('status', __('División eliminada correctamente.'));
    }
}
