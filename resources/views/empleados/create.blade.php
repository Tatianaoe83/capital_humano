<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nuevo Empleado') }}
            </h2>
            <a href="{{ route('empleados.index') }}" class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center">
                ← {{ __('Volver al listado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8" x-data="{ tab: 'datos' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pestañas --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex gap-6" aria-label="Tabs">
                    <button type="button"
                            @click="tab = 'datos'"
                            :class="tab === 'datos' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                        {{ __('Datos generales') }}
                    </button>
                    <button type="button"
                            @click="tab = 'documentos'"
                            :class="tab === 'documentos' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                        {{ __('Adjuntar documentos') }}
                    </button>
                    <button type="button"
                            @click="tab = 'historico'"
                            :class="tab === 'historico' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                        {{ __('Histórico') }}
                    </button>
                </nav>
            </div>

            {{-- Pestaña: Datos generales (formulario de creación) --}}
            <div x-show="tab === 'datos'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('empleados.store') }}">
                        @csrf
                        @include('empleados._form', ['empleado' => null, 'requiredPuesto' => true])
                        <div class="mt-6 flex gap-4">
                            <x-primary-button>{{ __('Crear empleado') }}</x-primary-button>
                            <a href="{{ route('empleados.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Pestaña: Documentos (solo información antes de crear) --}}
            <div x-show="tab === 'documentos'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="rounded-lg border-2 border-dashed border-gray-200 bg-gray-50/50 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-4">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Adjuntar documentos') }}</h3>
                        <p class="mt-2 max-w-sm mx-auto text-sm text-gray-500">
                            {{ __('Primero crea el empleado con la pestaña "Datos generales". Después de guardar serás redirigido a la ficha del empleado, donde podrás adjuntar documentos en esta misma pestaña.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Pestaña: Histórico (solo información antes de crear) --}}
            <div x-show="tab === 'historico'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="rounded-lg border-2 border-dashed border-gray-200 bg-gray-50/50 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-amber-600 mb-4">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Histórico') }}</h3>
                        <p class="mt-2 max-w-sm mx-auto text-sm text-gray-500">
                            {{ __('Al guardar el empleado se registrará automáticamente el movimiento de Alta inicial con la fecha de ingreso. Los cambios de puesto y las bajas o reingresos se irán registrando desde la ficha del empleado.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
