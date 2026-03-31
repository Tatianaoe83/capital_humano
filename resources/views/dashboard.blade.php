<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Resumen general del sistema de Capital Humano.') }}
            </p>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Empleados activos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['empleados_activos'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $stats['empleados_total'] }} {{ __('registrados en total') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Bajas registradas') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['empleados_baja'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $bajasMes }} {{ __('este mes') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Puestos activos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['puestos_activos'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $stats['areas'] }} {{ __('áreas configuradas') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Accesos del sistema') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['usuarios'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $stats['roles'] }} {{ __('roles y') }} {{ $stats['permisos'] }} {{ __('permisos') }}</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2">
                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h3 class="text-base font-semibold text-slate-900">{{ __('Indicadores clave') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ __('Estado actual de la operación y la estructura organizacional.') }}</p>
                        </div>
                        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Altas este mes') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $altasMes }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Divisiones') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['divisiones'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Unidades de negocio') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['unidades_negocio'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Direcciones') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['direcciones'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Gerencias') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['gerencias'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Puestos totales') }}</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['puestos'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="text-base font-semibold text-slate-900">{{ __('Lectura rápida') }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ __('Resumen ejecutivo del estado actual.') }}</p>
                    </div>
                    <div class="space-y-4 p-5 text-sm text-slate-600">
                        <div>
                            <p class="font-medium text-slate-900">{{ __('Plantilla laboral') }}</p>
                            <p class="mt-1">{{ __('Actualmente hay :activos empleados activos y :baja en baja.', ['activos' => $stats['empleados_activos'], 'baja' => $stats['empleados_baja']]) }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">{{ __('Estructura') }}</p>
                            <p class="mt-1">{{ __('La organización cuenta con :areas áreas y :puestos puestos registrados.', ['areas' => $stats['areas'], 'puestos' => $stats['puestos']]) }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">{{ __('Control de acceso') }}</p>
                            <p class="mt-1">{{ __('Se tienen :usuarios usuarios internos con :roles roles configurados.', ['usuarios' => $stats['usuarios'], 'roles' => $stats['roles']]) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="text-base font-semibold text-slate-900">{{ __('Ingresos recientes') }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ __('Últimos empleados incorporados al sistema.') }}</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($ingresosRecientes as $empleado)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }} {{ $empleado->nombre }}
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $empleado->puesto?->nombre ?? __('Sin puesto asignado') }}
                                    </p>
                                </div>
                                <span class="shrink-0 text-sm text-slate-500">
                                    {{ $empleado->fecha_ingreso?->format('d/m/Y') ?? '—' }}
                                </span>
                            </div>
                        @empty
                            <div class="px-5 py-6 text-sm text-slate-500">
                                {{ __('No hay ingresos registrados.') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="text-base font-semibold text-slate-900">{{ __('Movimientos recientes') }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ __('Altas, bajas y reingresos más recientes.') }}</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($movimientosRecientes as $movimiento)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $movimiento->empleado?->apellido_paterno }} {{ $movimiento->empleado?->apellido_materno }} {{ $movimiento->empleado?->nombre }}
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $movimiento->tipo }}
                                        @if ($movimiento->motivo)
                                            · {{ $movimiento->motivo }}
                                        @endif
                                    </p>
                                </div>
                                <span class="shrink-0 text-sm text-slate-500">
                                    {{ $movimiento->fecha?->format('d/m/Y') ?? '—' }}
                                </span>
                            </div>
                        @empty
                            <div class="px-5 py-6 text-sm text-slate-500">
                                {{ __('No hay movimientos registrados.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
