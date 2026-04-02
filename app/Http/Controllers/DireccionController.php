<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\UnidadNegocio;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Direccion::with(['unidadNegocio.division'])->withCount(['gerencias', 'areas']);

        if ($request->filled('unidad_negocio_id')) {
            $query->where('unidad_negocio_id', $request->unidad_negocio_id);
        }

        $direcciones = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $unidadesNegocio = UnidadNegocio::with('division')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.direcciones.index', compact('direcciones', 'unidadesNegocio'));
    }

    public function create()
    {
        $unidadesNegocio = UnidadNegocio::with('division')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.direcciones.create', compact('unidadesNegocio'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unidad_negocio_id' => ['required', 'exists:unidades_negocio,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        Direccion::create($validated);

        return redirect()->route('direcciones.index')
            ->with('status', __('Dirección creada correctamente.'));
    }

    public function edit(Direccion $direccione)
    {
        $unidadesNegocio = UnidadNegocio::with('division')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.direcciones.edit', compact('direccione', 'unidadesNegocio'));
    }

    public function update(Request $request, Direccion $direccione)
    {
        $validated = $request->validate([
            'unidad_negocio_id' => ['required', 'exists:unidades_negocio,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $direccione->update($validated);

        return redirect()->route('direcciones.index')
            ->with('status', __('Dirección actualizada correctamente.'));
    }

    public function destroy(Direccion $direccione)
    {
        $direccione->delete();

        return redirect()->route('direcciones.index')
            ->with('status', __('Dirección eliminada correctamente.'));
    }
}
