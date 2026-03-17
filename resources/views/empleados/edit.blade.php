<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empleado') }}: {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }} {{ $empleado->nombre }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8 space-y-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('empleados.update', $empleado) }}">
                        @csrf
                        @method('PUT')
                        @include('empleados._form', ['empleado' => $empleado, 'requiredPuesto' => true])
                        <div class="mt-6 flex gap-4">
                            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                            <a href="{{ route('empleados.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Historiales internos del empleado -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Historial de movimientos internos (puesto / departamento) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">
                        {{ __('Historial de Movimientos internos (puesto / departamento)') }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        {{ __('Aquí podrás registrar y consultar los cambios de puesto y/o área del empleado dentro de la organización.') }}
                    </p>
                    @if ($empleado->movimientosPuesto->isEmpty())
                        <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center text-sm text-gray-400">
                            {{ __('Sin movimientos registrados por el momento.') }}
                        </div>
                    @else
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Puesto / Área') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($empleado->movimientosPuesto as $mov)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-gray-700">
                                                {{ $mov->fecha_movimiento?->format('d/m/Y') ?? '—' }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-700">
                                                {{ $mov->puesto?->area?->nombre ?? '—' }} - {{ $mov->puesto?->nombre ?? '—' }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-500">
                                                {{ $mov->observaciones ?? '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historial de movimientos internos (alta, baja, reingreso) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">
                        {{ __('Historial de Movimientos internos (alta, baja, reingreso)') }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        {{ __('Se utilizará para registrar eventos de alta, baja, reingreso u otros movimientos administrativos relacionados con el empleado.') }}
                    </p>
                    @if ($empleado->movimientosAltaBaja->isEmpty())
                        <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center text-sm text-gray-400">
                            {{ __('Sin movimientos registrados por el momento.') }}
                        </div>
                    @else
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Tipo') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Motivo') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($empleado->movimientosAltaBaja as $mov)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-gray-700">
                                                {{ $mov->fecha?->format('d/m/Y') ?? '—' }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-700">
                                                {{ $mov->tipo }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-700">
                                                {{ $mov->motivo ?? '—' }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-500">
                                                {{ $mov->observaciones ?? '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
