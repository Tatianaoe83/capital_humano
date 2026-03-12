<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Direccion;
use App\Models\Gerencia;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $query = Area::with(['direccion.unidadNegocio', 'gerencia'])->withCount('puestos');

        if ($request->filled('direccion_id')) {
            $query->where('direccion_id', $request->direccion_id);
        }
        if ($request->filled('gerencia_id')) {
            $query->where('gerencia_id', $request->gerencia_id);
        }

        $areas = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();
        $gerencias = Gerencia::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.areas.index', compact('areas', 'direcciones', 'gerencias'));
    }

    public function create()
    {
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();
        $gerencias = Gerencia::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.areas.create', compact('direcciones', 'gerencias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'direccion_id' => ['required', 'exists:direcciones,id'],
            'gerencia_id' => [
                'nullable',
                'exists:gerencias,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && \App\Models\Gerencia::find($value)?->direccion_id != $request->direccion_id) {
                        $fail(__('La gerencia debe pertenecer a la dirección seleccionada.'));
                    }
                },
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        Area::create($validated);

        return redirect()->route('areas.index')
            ->with('status', __('Área creada correctamente.'));
    }

    public function edit(Area $area)
    {
        $direcciones = Direccion::with('unidadNegocio')->where('activo', true)->orderBy('nombre')->get();
        $gerencias = Gerencia::where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.areas.edit', compact('area', 'direcciones', 'gerencias'));
    }

    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'direccion_id' => ['required', 'exists:direcciones,id'],
            'gerencia_id' => [
                'nullable',
                'exists:gerencias,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && \App\Models\Gerencia::find($value)?->direccion_id != $request->direccion_id) {
                        $fail(__('La gerencia debe pertenecer a la dirección seleccionada.'));
                    }
                },
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);

        $area->update($validated);

        return redirect()->route('areas.index')
            ->with('status', __('Área actualizada correctamente.'));
    }

    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('areas.index')
            ->with('status', __('Área eliminada correctamente.'));
    }
}
