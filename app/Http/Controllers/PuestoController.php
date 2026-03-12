<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index(Request $request)
    {
        $query = Puesto::with('area.direccion.unidadNegocio');

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        $puestos = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $areas = Area::with('direccion')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.puestos.index', compact('puestos', 'areas'));
    }

    public function create()
    {
        $areas = Area::with('direccion.gerencias')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.puestos.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        Puesto::create($validated);

        return redirect()->route('puestos.index')
            ->with('status', __('Puesto creado correctamente.'));
    }

    public function edit(Puesto $puesto)
    {
        $areas = Area::with('direccion')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.puestos.edit', compact('puesto', 'areas'));
    }

    public function update(Request $request, Puesto $puesto)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $puesto->update($validated);

        return redirect()->route('puestos.index')
            ->with('status', __('Puesto actualizado correctamente.'));
    }

    public function destroy(Puesto $puesto)
    {
        $puesto->delete();

        return redirect()->route('puestos.index')
            ->with('status', __('Puesto eliminado correctamente.'));
    }
}
