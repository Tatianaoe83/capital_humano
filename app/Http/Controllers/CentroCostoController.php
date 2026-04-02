<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CentroCosto;
use App\Models\Division;
use App\Models\Gerencia;
use App\Models\UnidadNegocio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    public function index(Request $request)
    {
        $query = CentroCosto::with(['areas.direccion.unidadNegocio.division'])->withCount('areas');

        if ($request->filled('division_id')) {
            $query->whereHas('areas.direccion.unidadNegocio', function ($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        if ($request->filled('unidad_negocio_id')) {
            $query->whereHas('areas.direccion', function ($q) use ($request) {
                $q->where('unidad_negocio_id', $request->unidad_negocio_id);
            });
        }

        if ($request->filled('gerencia_id')) {
            $query->whereHas('areas', function ($q) use ($request) {
                $q->where('gerencia_id', $request->gerencia_id);
            });
        }

        if ($request->filled('q')) {
            $q = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $request->q).'%';
            $query->where('nombre', 'like', $q);
        }

        $centrosCostos = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $divisiones = Division::where('activo', true)->orderBy('nombre')->get();
        $unidadesNegocio = UnidadNegocio::with('division')->where('activo', true)->orderBy('nombre')->get();
        $gerencias = Gerencia::with('direccion.unidadNegocio.division')->where('activo', true)->orderBy('nombre')->get();

        return view('catalogos.centros-costos.index', compact('centrosCostos', 'divisiones', 'unidadesNegocio', 'gerencias'));
    }

    public function create()
    {
        return view('catalogos.centros-costos.create', $this->datosFormularioAreas());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
            'area_ids' => ['required', 'array', 'min:1'],
            'area_ids.*' => ['exists:areas,id'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);
        $validated['unidad_negocio_id'] = null;
        $areaIds = $validated['area_ids'];
        unset($validated['area_ids']);

        $centroCosto = CentroCosto::create($validated);
        $centroCosto->areas()->sync($areaIds);

        return redirect()->route('centros-costos.index')
            ->with('status', __('Centro de costos creado correctamente.'));
    }

    public function edit(CentroCosto $centroCosto)
    {
        $centroCosto->load('areas');

        return view('catalogos.centros-costos.edit', array_merge(
            ['centroCosto' => $centroCosto],
            $this->datosFormularioAreas()
        ));
    }

    public function update(Request $request, CentroCosto $centroCosto)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
            'area_ids' => ['required', 'array', 'min:1'],
            'area_ids.*' => ['exists:areas,id'],
        ]);

        $validated['activo'] = $request->boolean('activo', true);
        $validated['unidad_negocio_id'] = null;
        $areaIds = $validated['area_ids'];
        unset($validated['area_ids']);

        $centroCosto->update($validated);
        $centroCosto->areas()->sync($areaIds);

        return redirect()->route('centros-costos.index')
            ->with('status', __('Centro de costos actualizado correctamente.'));
    }

    public function destroy(CentroCosto $centroCosto)
    {
        $centroCosto->delete();

        return redirect()->route('centros-costos.index')
            ->with('status', __('Centro de costos eliminado correctamente.'));
    }

    /**
     * @return array{areas: Collection<int, Area>, divisiones: Collection<int, Division>, unidadesNegocio: Collection<int, UnidadNegocio>, gerencias: Collection<int, Gerencia>}
     */
    private function datosFormularioAreas(): array
    {
        $areas = Area::query()
            ->with(['direccion.unidadNegocio.division', 'gerencia'])
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $divisiones = Division::where('activo', true)->orderBy('nombre')->get();
        $unidadesNegocio = UnidadNegocio::with('division')->where('activo', true)->orderBy('nombre')->get();
        $gerencias = Gerencia::with('direccion.unidadNegocio.division')->where('activo', true)->orderBy('nombre')->get();

        return compact('areas', 'divisiones', 'unidadesNegocio', 'gerencias');
    }
}
