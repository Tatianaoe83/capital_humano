<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\UnidadNegocio;
use Illuminate\Http\Request;

class UnidadNegocioController extends Controller
{
    public function index(Request $request)
    {
        $query = UnidadNegocio::with('division')->withCount('direcciones');

        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        $unidadesNegocio = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $divisiones = Division::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.unidades-negocio.index', compact('unidadesNegocio', 'divisiones'));
    }

    public function create()
    {
        $divisiones = Division::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.unidades-negocio.create', compact('divisiones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_id' => ['required', 'exists:divisiones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        UnidadNegocio::create($validated);

        return redirect()->route('unidades-negocio.index')
            ->with('status', __('Unidad de negocio creada correctamente.'));
    }

    public function edit(UnidadNegocio $unidadNegocio)
    {
        $divisiones = Division::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.unidades-negocio.edit', compact('unidadNegocio', 'divisiones'));
    }

    public function update(Request $request, UnidadNegocio $unidadNegocio)
    {
        $validated = $request->validate([
            'division_id' => ['required', 'exists:divisiones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $unidadNegocio->update($validated);

        return redirect()->route('unidades-negocio.index')
            ->with('status', __('Unidad de negocio actualizada correctamente.'));
    }

    public function destroy(UnidadNegocio $unidadNegocio)
    {
        $unidadNegocio->delete();

        return redirect()->route('unidades-negocio.index')
            ->with('status', __('Unidad de negocio eliminada correctamente.'));
    }
}
