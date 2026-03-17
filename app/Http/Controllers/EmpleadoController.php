<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EmpleadoDocumento;
use App\Models\EmpleadoMovimientoAltaBaja;
use App\Models\EmpleadoMovimientoPuesto;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $empleados = Empleado::with('jefeInmediato', 'puesto.area')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombre')
            ->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $empleados = Empleado::orderBy('apellido_paterno')->orderBy('nombre')->get();
        $puestos = Puesto::with('area.direccion.unidadNegocio', 'area.gerencia')->where('activo', true)->orderBy('nombre')->get();

        return view('empleados.create', compact('empleados', 'puestos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date'],
            'puesto_id' => ['required', 'exists:puestos,id'],
            'jefe_inmediato_id' => ['nullable', 'exists:empleados,id'],
            'sindicalizado' => ['nullable', 'boolean'],
            'tipo_prestacion' => ['nullable', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'curp' => ['nullable', 'string', 'max:18'],
            'nss' => ['nullable', 'string', 'max:255'],
            'registro_patronal' => ['nullable', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'domicilio' => ['nullable', 'string'],
            'correo_personal' => ['nullable', 'email', 'max:255'],
            'correo_institucional' => ['nullable', 'email', 'max:255'],
            'estado_civil' => ['nullable', 'string', 'max:50'],
            'sexo' => ['nullable', 'string', 'max:20'],
            'hijos' => ['nullable', 'integer', 'min:0'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'personal' => ['nullable', 'string', 'max:50'],
            'tipo_contrato' => ['nullable', 'string', 'max:255'],
            'numero_contacto' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['sindicalizado'] = $request->boolean('sindicalizado', false);
        $validated['activo'] = true;

        $empleado = Empleado::create($validated);

        EmpleadoMovimientoAltaBaja::create([
            'empleado_id' => $empleado->id,
            'tipo' => EmpleadoMovimientoAltaBaja::TIPO_ALTA,
            'fecha' => $empleado->fecha_ingreso,
            'motivo' => __('Alta inicial'),
            'observaciones' => null,
        ]);

        return redirect()->route('empleados.show', $empleado)
            ->with('status', __('Empleado creado correctamente.'));
    }

    public function show(Empleado $empleado)
    {
        $empleado->load('jefeInmediato', 'puesto.area', 'movimientosPuesto.puesto.area', 'movimientosAltaBaja', 'documentos');

        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $empleados = Empleado::where('id', '!=', $empleado->id)
            ->orderBy('apellido_paterno')
            ->orderBy('nombre')
            ->get();
        $puestos = Puesto::with('area.direccion.unidadNegocio', 'area.gerencia')->where('activo', true)->orderBy('nombre')->get();

        $empleado->load('movimientosPuesto.puesto.area', 'movimientosAltaBaja', 'documentos');

        return view('empleados.edit', compact('empleado', 'empleados', 'puestos'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date'],
            'puesto_id' => ['required', 'exists:puestos,id'],
            'jefe_inmediato_id' => ['nullable', 'exists:empleados,id'],
            'sindicalizado' => ['nullable', 'boolean'],
            'tipo_prestacion' => ['nullable', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'curp' => ['nullable', 'string', 'max:18'],
            'nss' => ['nullable', 'string', 'max:255'],
            'registro_patronal' => ['nullable', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'domicilio' => ['nullable', 'string'],
            'correo_personal' => ['nullable', 'email', 'max:255'],
            'correo_institucional' => ['nullable', 'email', 'max:255'],
            'estado_civil' => ['nullable', 'string', 'max:50'],
            'sexo' => ['nullable', 'string', 'max:20'],
            'hijos' => ['nullable', 'integer', 'min:0'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'personal' => ['nullable', 'string', 'max:50'],
            'tipo_contrato' => ['nullable', 'string', 'max:255'],
            'numero_contacto' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['sindicalizado'] = $request->boolean('sindicalizado', false);

        $puestoAnteriorId = $empleado->puesto_id;
        $nuevoPuestoId = (int) $validated['puesto_id'];

        if ($puestoAnteriorId !== $nuevoPuestoId) {
            $puestoAnterior = $empleado->puesto;
            $observaciones = $puestoAnterior
                ? __('Cambio desde: :puesto', ['puesto' => $puestoAnterior->nombre])
                : null;

            EmpleadoMovimientoPuesto::create([
                'empleado_id' => $empleado->id,
                'puesto_id' => $nuevoPuestoId,
                'fecha_movimiento' => now(),
                'observaciones' => $observaciones,
            ]);
        }

        $empleado->update($validated);

        return redirect()->route('empleados.edit', $empleado)
            ->with('status', __('Empleado actualizado correctamente.'));
    }

    public function toggleBaja(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'motivo' => ['nullable', 'string', 'max:255'],
        ]);

        if ($empleado->activo) {
            EmpleadoMovimientoAltaBaja::create([
                'empleado_id' => $empleado->id,
                'tipo' => EmpleadoMovimientoAltaBaja::TIPO_BAJA,
                'fecha' => now(),
                'motivo' => $validated['motivo'] ?? null,
                'observaciones' => null,
            ]);
            $empleado->update(['activo' => false]);
            $message = __('Empleado dado de baja correctamente.');
        } else {
            EmpleadoMovimientoAltaBaja::create([
                'empleado_id' => $empleado->id,
                'tipo' => EmpleadoMovimientoAltaBaja::TIPO_REINGRESO,
                'fecha' => now(),
                'motivo' => $validated['motivo'] ?? null,
                'observaciones' => null,
            ]);
            $empleado->update(['activo' => true]);
            $message = __('Empleado reactivado correctamente.');
        }

        return redirect()->route('empleados.index')->with('status', $message);
    }

    public function storeDocument(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'file', 'max:10240'], // 10 MB
        ]);

        $file = $request->file('documento');
        $dir = 'empleados_docs/'.$empleado->id;
        $path = $file->store($dir, 'local');

        EmpleadoDocumento::create([
            'empleado_id' => $empleado->id,
            'nombre' => $validated['nombre'],
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta' => $path,
            'mime_type' => $file->getMimeType(),
            'tamano' => $file->getSize(),
        ]);

        return redirect()->back()
            ->with('status', __('Documento adjuntado correctamente.'))
            ->with('tab_activo', 'documentos');
    }

    public function destroyDocument(Empleado $empleado, EmpleadoDocumento $documento)
    {
        if ($documento->empleado_id !== $empleado->id) {
            abort(404);
        }
        if (Storage::disk('local')->exists($documento->ruta)) {
            Storage::disk('local')->delete($documento->ruta);
        }
        $documento->delete();

        return redirect()->back()
            ->with('status', __('Documento eliminado.'))
            ->with('tab_activo', 'documentos');
    }

    public function downloadDocument(Empleado $empleado, EmpleadoDocumento $documento): StreamedResponse
    {
        if ($documento->empleado_id !== $empleado->id || ! Storage::disk('local')->exists($documento->ruta)) {
            abort(404);
        }

        return Storage::disk('local')->download(
            $documento->ruta,
            $documento->nombre_archivo,
            ['Content-Type' => $documento->mime_type]
        );
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('status', __('Empleado eliminado correctamente.'));
    }
}
