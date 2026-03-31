@props(['empleado' => null])

@php
    $empleados = $empleados ?? collect();
    $puestos = $puestos ?? collect();
    $requiredPuesto = $requiredPuesto ?? false;
    $selectClass = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500';
    $textareaClass = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Datos personales --}}
    <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos personales') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <x-input-label for="apellido_paterno" :value="__('Apellido paterno')" />
                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" class="mt-1 block w-full" :value="old('apellido_paterno', $empleado?->apellido_paterno)" required />
                <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="apellido_materno" :value="__('Apellido materno')" />
                <x-text-input id="apellido_materno" name="apellido_materno" type="text" class="mt-1 block w-full" :value="old('apellido_materno', $empleado?->apellido_materno)" />
            </div>
            <div>
                <x-input-label for="nombre" :value="__('Nombre(s)')" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $empleado?->nombre)" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento', $empleado?->fecha_nacimiento?->format('Y-m-d'))" />
            </div>
            <div>
                <x-input-label for="sexo" :value="__('Sexo')" />
                <select id="sexo" name="sexo" class="{{ $selectClass }}">
                    <option value="">{{ __('Seleccione...') }}</option>
                    <option value="M" {{ old('sexo', $empleado?->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo', $empleado?->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div>
                <x-input-label for="estado_civil" :value="__('Estado civil')" />
                <select id="estado_civil" name="estado_civil" class="{{ $selectClass }}">
                    <option value="">{{ __('Seleccione...') }}</option>
                    <option value="Soltero" {{ old('estado_civil', $empleado?->estado_civil) == 'Soltero' ? 'selected' : '' }}>Soltero(a)</option>
                    <option value="Casado" {{ old('estado_civil', $empleado?->estado_civil) == 'Casado' ? 'selected' : '' }}>Casado(a)</option>
                    <option value="Divorciado" {{ old('estado_civil', $empleado?->estado_civil) == 'Divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                    <option value="Viudo" {{ old('estado_civil', $empleado?->estado_civil) == 'Viudo' ? 'selected' : '' }}>Viudo(a)</option>
                </select>
            </div>
            <div>
                <x-input-label for="hijos" :value="__('Hijos')" />
                <x-text-input id="hijos" name="hijos" type="number" min="0" class="mt-1 block w-full" :value="old('hijos', $empleado?->hijos ?? 0)" />
            </div>
        </div>
    </div>

    {{-- Datos laborales --}}
    <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos laborales') }}</h3>
        <div class="space-y-4">
            <div>
                <x-input-label for="puesto_id" :value="__('Puesto')" />
                <select id="puesto_id" name="puesto_id" {{ $requiredPuesto ? 'required' : '' }} class="{{ $selectClass }}">
                    <option value="">{{ __('Seleccione...') }}</option>
                    @foreach ($puestos as $p)
                        <option value="{{ $p->id }}" {{ old('puesto_id', $empleado?->puesto_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->area->nombre ?? '' }} - {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('puesto_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="fecha_ingreso" :value="__('Fecha de ingreso')" />
                <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" :value="old('fecha_ingreso', $empleado?->fecha_ingreso?->format('Y-m-d'))" required />
                <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="jefe_inmediato_id" :value="__('Jefe inmediato')" />
                <select id="jefe_inmediato_id" name="jefe_inmediato_id" class="{{ $selectClass }}">
                    <option value="">{{ __('Seleccione...') }}</option>
                    @foreach ($empleados as $emp)
                        <option value="{{ $emp->id }}" {{ old('jefe_inmediato_id', $empleado?->jefe_inmediato_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->apellido_paterno }} {{ $emp->apellido_materno }} {{ $emp->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-input-label for="sindicalizado" :value="__('Sindicalizado')" />
                <label class="flex items-center mt-1">
                    <input type="checkbox" name="sindicalizado" value="1" {{ old('sindicalizado', $empleado?->sindicalizado) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Sí</span>
                </label>
            </div>
            <div>
                <x-input-label for="tipo_prestacion" :value="__('Tipo de prestación')" />
                <x-text-input id="tipo_prestacion" name="tipo_prestacion" type="text" class="mt-1 block w-full" :value="old('tipo_prestacion', $empleado?->tipo_prestacion)" />
            </div>
            <div>
                <x-input-label for="personal" :value="__('Personal (Fijo/Eventual)')" />
                <select id="personal" name="personal" class="{{ $selectClass }}">
                    <option value="">{{ __('Seleccione...') }}</option>
                    <option value="FIJO" {{ old('personal', $empleado?->personal) == 'FIJO' ? 'selected' : '' }}>Fijo</option>
                    <option value="EVENTUAL" {{ old('personal', $empleado?->personal) == 'EVENTUAL' ? 'selected' : '' }}>Eventual</option>
                </select>
            </div>
            <div>
                <x-input-label for="tipo_contrato" :value="__('Tipo de contrato')" />
                <x-text-input id="tipo_contrato" name="tipo_contrato" type="text" class="mt-1 block w-full" :value="old('tipo_contrato', $empleado?->tipo_contrato)" />
            </div>
            <div>
                <x-input-label for="ubicacion" :value="__('Ubicación')" />
                <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" :value="old('ubicacion', $empleado?->ubicacion)" />
            </div>
        </div>
    </div>
</div>

{{-- Datos fiscales y seguridad social --}}
<div class="mt-6 space-y-4">
    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos fiscales y seguridad social') }}</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <x-input-label for="curp" :value="__('CURP')" />
            <x-text-input id="curp" name="curp" type="text" maxlength="18" class="mt-1 block w-full" :value="old('curp', $empleado?->curp)" />
        </div>
        <div>
            <x-input-label for="nss" :value="__('NSS')" />
            <x-text-input id="nss" name="nss" type="text" class="mt-1 block w-full" :value="old('nss', $empleado?->nss)" />
        </div>
        <div>
            <x-input-label for="rfc" :value="__('RFC')" />
            <x-text-input id="rfc" name="rfc" type="text" maxlength="13" class="mt-1 block w-full" :value="old('rfc', $empleado?->rfc)" />
        </div>
        <div>
            <x-input-label for="registro_patronal" :value="__('Registro patronal')" />
            <x-text-input id="registro_patronal" name="registro_patronal" type="text" class="mt-1 block w-full" :value="old('registro_patronal', $empleado?->registro_patronal)" />
        </div>
    </div>
</div>

{{-- Contacto --}}
<div class="mt-6 space-y-4">
    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Contacto') }}</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $empleado?->telefono)" />
        </div>
        <div>
            <x-input-label for="numero_contacto" :value="__('Número de contacto')" />
            <x-text-input id="numero_contacto" name="numero_contacto" type="text" class="mt-1 block w-full" :value="old('numero_contacto', $empleado?->numero_contacto)" />
        </div>
        <div class="sm:col-span-2 lg:col-span-1">
            <x-input-label for="correo_personal" :value="__('Correo personal')" />
            <x-text-input id="correo_personal" name="correo_personal" type="email" class="mt-1 block w-full" :value="old('correo_personal', $empleado?->correo_personal)" />
        </div>
        <div>
            <x-input-label for="correo_institucional" :value="__('Correo institucional')" />
            <x-text-input id="correo_institucional" name="correo_institucional" type="email" class="mt-1 block w-full" :value="old('correo_institucional', $empleado?->correo_institucional)" />
        </div>
        <div class="sm:col-span-2">
            <x-input-label for="domicilio" :value="__('Domicilio')" />
            <textarea id="domicilio" name="domicilio" rows="2" class="{{ $textareaClass }}">{{ old('domicilio', $empleado?->domicilio) }}</textarea>
        </div>
    </div>
</div>
