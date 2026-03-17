<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ver Empleado') }}: {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }} {{ $empleado->nombre }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('empleados.edit', $empleado) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('empleados.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← {{ __('Volver al listado') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8" x-data="{ tab: '{{ session('tab_activo', 'datos') }}' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

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
                        @if($empleado->documentos->count() > 0)
                            <span class="ml-1 rounded-full bg-gray-200 px-2 py-0.5 text-xs">{{ $empleado->documentos->count() }}</span>
                        @endif
                    </button>
                    <button type="button"
                            @click="tab = 'historico'"
                            :class="tab === 'historico' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                        {{ __('Histórico') }}
                    </button>
                </nav>
            </div>

            {{-- Pestaña: Datos generales (solo lectura) --}}
            <div x-show="tab === 'datos'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    @include('empleados._datos_readonly', ['empleado' => $empleado])
                    <div class="mt-6 pt-4 border-t">
                        <a href="{{ route('empleados.edit', $empleado) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            {{ __('Editar datos') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pestaña: Documentos (igual que en edit) --}}
            <div x-show="tab === 'documentos'" x-cloak class="space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Nuevo documento') }}</h3>
                        <form action="{{ route('empleados.documentos.store', $empleado) }}" method="POST" enctype="multipart/form-data" class="max-w-xl space-y-4">
                            @csrf
                            <div>
                                <label for="doc_nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre o descripción') }}</label>
                                <input type="text" name="nombre" id="doc_nombre" value="{{ old('nombre') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="{{ __('Ej. CURP, Acta de nacimiento, Contrato') }}">
                            </div>
                            <div>
                                <label for="doc_archivo" class="block text-sm font-medium text-gray-700">{{ __('Archivo') }}</label>
                                <input type="file" name="documento" id="doc_archivo" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">{{ __('Máximo 10 MB. PDF, Word, imágenes.') }}</p>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('Subir documento') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Documentos adjuntos') }}</h3>
                        @if($empleado->documentos->isEmpty())
                            <div class="rounded-lg border-2 border-dashed border-gray-200 py-12 text-center">
                                <p class="text-sm text-gray-500">{{ __('No hay documentos adjuntos.') }}</p>
                            </div>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($empleado->documentos as $doc)
                                    <li class="flex items-center justify-between py-3 first:pt-0">
                                        <div class="flex min-w-0 flex-1 items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900">{{ $doc->nombre }}</p>
                                                <p class="text-xs text-gray-500">{{ $doc->nombre_archivo }} · {{ number_format($doc->tamano / 1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex shrink-0 gap-2">
                                            <a href="{{ route('empleados.documentos.download', [$empleado, $doc]) }}"
                                               class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50">
                                                {{ __('Descargar') }}
                                            </a>
                                            <form action="{{ route('empleados.documentos.destroy', [$empleado, $doc]) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('{{ __('¿Eliminar este documento?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md border border-red-200 bg-white px-3 py-1.5 text-sm text-red-700 hover:bg-red-50">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pestaña: Histórico --}}
            <div x-show="tab === 'historico'" x-cloak class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100">
                                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('Altas, bajas y reingresos') }}</h3>
                            </div>
                            @if ($empleado->movimientosAltaBaja->isEmpty())
                                <div class="rounded-lg border-2 border-dashed border-gray-200 py-8 text-center text-sm text-gray-500">
                                    {{ __('Sin movimientos registrados.') }}
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($empleado->movimientosAltaBaja as $mov)
                                        <div class="rounded-lg border border-gray-200 bg-gray-50/50 p-4">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                @if($mov->tipo === 'ALTA') bg-green-100 text-green-800
                                                @elseif($mov->tipo === 'BAJA') bg-red-100 text-red-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">{{ $mov->tipo }}</span>
                                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $mov->fecha?->format('d/m/Y') ?? '—' }}</p>
                                            @if($mov->motivo)<p class="mt-0.5 text-sm text-gray-600">{{ $mov->motivo }}</p>@endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100">
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('Cambios de puesto') }}</h3>
                            </div>
                            @if ($empleado->movimientosPuesto->isEmpty())
                                <div class="rounded-lg border-2 border-dashed border-gray-200 py-8 text-center text-sm text-gray-500">
                                    {{ __('Sin movimientos registrados.') }}
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($empleado->movimientosPuesto as $mov)
                                        <div class="rounded-lg border border-gray-200 bg-gray-50/50 p-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $mov->puesto?->area?->nombre ?? '—' }} · {{ $mov->puesto?->nombre ?? '—' }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $mov->fecha_movimiento?->format('d/m/Y') ?? '—' }}</p>
                                            @if($mov->observaciones)<p class="mt-1 text-sm text-gray-600">{{ $mov->observaciones }}</p>@endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
