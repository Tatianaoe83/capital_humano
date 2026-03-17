@props(['empleado'])

@php
    $e = $empleado;
    $sexoLabel = $e->sexo === 'M' ? 'Masculino' : ($e->sexo === 'F' ? 'Femenino' : '—');
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos personales') }}</h3>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div><dt class="text-gray-500">{{ __('Apellido paterno') }}</dt><dd class="font-medium text-gray-900">{{ $e->apellido_paterno ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Apellido materno') }}</dt><dd class="font-medium text-gray-900">{{ $e->apellido_materno ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Nombre(s)') }}</dt><dd class="font-medium text-gray-900">{{ $e->nombre ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Fecha de nacimiento') }}</dt><dd class="font-medium text-gray-900">{{ $e->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Sexo') }}</dt><dd class="font-medium text-gray-900">{{ $sexoLabel }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Estado civil') }}</dt><dd class="font-medium text-gray-900">{{ $e->estado_civil ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Hijos') }}</dt><dd class="font-medium text-gray-900">{{ $e->hijos ?? '—' }}</dd></div>
        </dl>
    </div>
    <div class="space-y-4">
        <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos laborales') }}</h3>
        <dl class="space-y-3 text-sm">
            <div><dt class="text-gray-500">{{ __('Puesto') }}</dt><dd class="font-medium text-gray-900">{{ $e->puesto?->area?->nombre ?? '—' }} · {{ $e->puesto?->nombre ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Fecha de ingreso') }}</dt><dd class="font-medium text-gray-900">{{ $e->fecha_ingreso?->format('d/m/Y') ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Jefe inmediato') }}</dt><dd class="font-medium text-gray-900">{{ $e->jefeInmediato ? $e->jefeInmediato->apellido_paterno . ' ' . $e->jefeInmediato->apellido_materno . ' ' . $e->jefeInmediato->nombre : '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Sindicalizado') }}</dt><dd class="font-medium text-gray-900">{{ $e->sindicalizado ? __('Sí') : __('No') }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Tipo de prestación') }}</dt><dd class="font-medium text-gray-900">{{ $e->tipo_prestacion ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Personal') }}</dt><dd class="font-medium text-gray-900">{{ $e->personal ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Tipo de contrato') }}</dt><dd class="font-medium text-gray-900">{{ $e->tipo_contrato ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Ubicación') }}</dt><dd class="font-medium text-gray-900">{{ $e->ubicacion ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">{{ __('Estado') }}</dt><dd class="font-medium"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $e->activo ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">{{ $e->activo ? __('Activo') : __('De baja') }}</span></dd></div>
        </dl>
    </div>
</div>

<div class="mt-6 space-y-4">
    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Datos fiscales y seguridad social') }}</h3>
    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
        <div><dt class="text-gray-500">{{ __('CURP') }}</dt><dd class="font-medium text-gray-900">{{ $e->curp ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('NSS') }}</dt><dd class="font-medium text-gray-900">{{ $e->nss ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('RFC') }}</dt><dd class="font-medium text-gray-900">{{ $e->rfc ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('Registro patronal') }}</dt><dd class="font-medium text-gray-900">{{ $e->registro_patronal ?? '—' }}</dd></div>
    </dl>
</div>

<div class="mt-6 space-y-4">
    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">{{ __('Contacto') }}</h3>
    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
        <div><dt class="text-gray-500">{{ __('Teléfono') }}</dt><dd class="font-medium text-gray-900">{{ $e->telefono ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('Número de contacto') }}</dt><dd class="font-medium text-gray-900">{{ $e->numero_contacto ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('Correo personal') }}</dt><dd class="font-medium text-gray-900">{{ $e->correo_personal ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">{{ __('Correo institucional') }}</dt><dd class="font-medium text-gray-900">{{ $e->correo_institucional ?? '—' }}</dd></div>
        <div class="sm:col-span-2"><dt class="text-gray-500">{{ __('Domicilio') }}</dt><dd class="font-medium text-gray-900">{{ $e->domicilio ?? '—' }}</dd></div>
    </dl>
</div>
