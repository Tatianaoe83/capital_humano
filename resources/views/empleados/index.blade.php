<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Empleados') }}
                </h2>
                <p class="mt-0.5 text-sm text-gray-500">
                    {{ __('Gestión de empleados y su información') }}
                </p>
            </div>
            <a href="{{ route('empleados.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 w-full sm:w-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Agregar Empleado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8" x-data="modalToggleBaja()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <livewire:empleados-table />
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
                     class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6">
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
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="{{ __('Opcional') }}">
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button"
                                    @click="cerrar()"
                                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Cancelar') }}
                            </button>
                            <button type="submit"
                                    class="rounded-lg border border-transparent bg-slate-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    x-text="accion === 'baja' ? '{{ __('Dar de baja') }}' : '{{ __('Reactivar') }}'">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
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
