<div>
    {{-- Tarjetas de resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-500">{{ __('Total Empleados') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $total }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-500">{{ __('Activos') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $activos }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-500">{{ __('Inactivos / Baja') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $inactivos }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Búsqueda (live, sin recargar) --}}
    <div class="mb-6">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="search"
                   wire:model.live.debounce.300ms="search"
                   placeholder="{{ __('Buscar por nombre, departamento o puesto...') }}"
                   class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('No. Empleado') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre completo') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Departamento') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Puesto') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha ingreso') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estatus') }}</th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($empleados as $e)
                        <tr class="{{ $e->activo ? '' : 'bg-gray-50' }} hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                EMP-{{ str_pad($e->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $e->apellido_paterno }} {{ $e->apellido_materno }} {{ $e->nombre }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                {{ $e->puesto?->area?->nombre ?? '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                {{ $e->puesto?->nombre ?? '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $e->fecha_ingreso?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($e->activo)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800">
                                        {{ __('Activo') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                        {{ __('De baja') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('empleados.show', $e) }}"
                                       class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors"
                                       title="{{ __('Ver') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('empleados.edit', $e) }}"
                                       class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition-colors"
                                       title="{{ __('Editar') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($e->activo)
                                        <button type="button"
                                            data-empleado-id="{{ $e->id }}"
                                            data-empleado-nombre="{{ e($e->apellido_paterno . ' ' . $e->apellido_materno . ' ' . $e->nombre) }}"
                                            data-accion="baja"
                                            @click="abrir($event.currentTarget.dataset.empleadoId, $event.currentTarget.dataset.empleadoNombre, $event.currentTarget.dataset.accion)"
                                            class="p-2 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                            title="{{ __('Dar de baja') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button"
                                            data-empleado-id="{{ $e->id }}"
                                            data-empleado-nombre="{{ e($e->apellido_paterno . ' ' . $e->apellido_materno . ' ' . $e->nombre) }}"
                                            data-accion="reactivar"
                                            @click="abrir($event.currentTarget.dataset.empleadoId, $event.currentTarget.dataset.empleadoNombre, $event.currentTarget.dataset.accion)"
                                            class="p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 transition-colors"
                                            title="{{ __('Reactivar') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <form action="{{ route('empleados.destroy', $e) }}" method="POST" class="inline"
                                          onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este empleado?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors"
                                                title="{{ __('Eliminar') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 sm:px-6 py-12 text-center text-gray-500">
                                {{ $search ? __('No se encontraron empleados.') : __('No hay empleados registrados.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Paginación visible --}}
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 sm:px-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600">
                    @if($empleados->total() > 0)
                        {{ __('Mostrando') }} {{ $empleados->firstItem() }} {{ __('a') }} {{ $empleados->lastItem() }} {{ __('de') }} {{ $empleados->total() }} {{ __('registros') }}
                    @else
                        {{ __('0 registros') }}
                    @endif
                </p>
                <div>
                    {{ $empleados->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
