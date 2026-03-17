<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Empleados') }}
            </h2>
            <a href="{{ route('empleados.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 w-full sm:w-auto">
                {{ __('Nuevo Empleado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8" x-data="modalToggleBaja()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre completo') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Puesto') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Jefe inmediato') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha ingreso') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($empleados as $e)
                                    <tr class="{{ $e->activo ? '' : 'bg-gray-100 opacity-75' }}">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $e->apellido_paterno }} {{ $e->apellido_materno }} {{ $e->nombre }}
                                            @if(!$e->activo)
                                                <span class="ml-1 text-xs font-normal text-amber-600">({{ __('De baja') }})</span>
                                            @endif
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            {{ $e->puesto?->nombre ?? '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            {{ $e->jefeInmediato ? $e->jefeInmediato->apellido_paterno . ' ' . $e->jefeInmediato->apellido_materno . ' ' . $e->jefeInmediato->nombre : '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $e->fecha_ingreso?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($e->activo)
                                                <button type="button"
                                                    data-empleado-id="{{ $e->id }}"
                                                    data-empleado-nombre="{{ e($e->apellido_paterno . ' ' . $e->apellido_materno . ' ' . $e->nombre) }}"
                                                    data-accion="baja"
                                                    @click="abrir($event.currentTarget.dataset.empleadoId, $event.currentTarget.dataset.empleadoNombre, $event.currentTarget.dataset.accion)"
                                                    class="text-amber-600 hover:text-amber-900 mr-2">
                                                    {{ __('Dar de baja') }}
                                                </button>
                                            @else
                                                <button type="button"
                                                    data-empleado-id="{{ $e->id }}"
                                                    data-empleado-nombre="{{ e($e->apellido_paterno . ' ' . $e->apellido_materno . ' ' . $e->nombre) }}"
                                                    data-accion="reactivar"
                                                    @click="abrir($event.currentTarget.dataset.empleadoId, $event.currentTarget.dataset.empleadoNombre, $event.currentTarget.dataset.accion)"
                                                    class="text-green-600 hover:text-green-900 mr-2">
                                                    {{ __('Reactivar') }}
                                                </button>
                                            @endif
                                            <a href="{{ route('empleados.show', $e) }}" class="text-gray-600 hover:text-gray-900 mr-2">{{ __('Ver') }}</a>
                                            <a href="{{ route('empleados.edit', $e) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            <form action="{{ route('empleados.destroy', $e) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este empleado?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay empleados registrados.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $empleados->links() }}</div>
                </div>
            </div>
        </div>

        {{-- Modal Dar de baja / Reactivar (Alpine.js) --}}
        <div x-show="open"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="open"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="cerrar()"></div>

                <div x-show="open"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title" x-text="titulo"></h3>
                    <p class="mt-1 text-sm text-gray-500" x-show="empleadoNombre" x-text="empleadoNombre"></p>

                    <form :action="urlSubmit" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="motivo" class="block text-sm font-medium text-gray-700">{{ __('Motivo') }}</label>
                            <input type="text"
                                   name="motivo"
                                   id="motivo"
                                   x-model="motivo"
                                   maxlength="255"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="{{ __('Opcional') }}">
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button"
                                    @click="cerrar()"
                                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Cancelar') }}
                            </button>
                            <button type="submit"
                                    class="rounded-md border border-transparent bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    x-text="accion === 'baja' ? '{{ __('Dar de baja') }}' : '{{ __('Reactivar') }}'">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        function modalToggleBaja() {
            const baseUrl = '{{ url('empleados') }}';
            return {
                open: false,
                empleadoId: null,
                empleadoNombre: '',
                accion: 'baja',
                motivo: '',
                get titulo() {
                    return this.accion === 'baja' ? '{{ __('Dar de baja') }}' : '{{ __('Reactivar empleado') }}';
                },
                get urlSubmit() {
                    return this.empleadoId ? `${baseUrl}/${this.empleadoId}/toggle-baja` : baseUrl;
                },
                abrir(id, nombre, accion) {
                    this.empleadoId = id;
                    this.empleadoNombre = nombre || '';
                    this.accion = accion || 'baja';
                    this.motivo = '';
                    this.open = true;
                },
                cerrar() {
                    this.open = false;
                }
            };
        }
    </script>
</x-app-layout>
