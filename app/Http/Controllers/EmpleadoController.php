<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $empleados = Empleado::with('jefeInmediato')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombre')
            ->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $empleados = Empleado::orderBy('apellido_paterno')->orderBy('nombre')->get();

        return view('empleados.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date'],
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

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('status', __('Empleado creado correctamente.'));
    }

    public function edit(Empleado $empleado)
    {
        $empleados = Empleado::where('id', '!=', $empleado->id)
            ->orderBy('apellido_paterno')
            ->orderBy('nombre')
            ->get();

        return view('empleados.edit', compact('empleado', 'empleados'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date'],
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

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('status', __('Empleado actualizado correctamente.'));
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('status', __('Empleado eliminado correctamente.'));
    }
}
