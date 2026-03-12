<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Área') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('areas.update', $area) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="direccion_id" :value="__('Dirección')" />
                            <select id="direccion_id" name="direccion_id" required class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($direcciones as $d)
                                    <option value="{{ $d->id }}" {{ old('direccion_id', $area->direccion_id) == $d->id ? 'selected' : '' }}>{{ $d->unidadNegocio->nombre }} / {{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="gerencia_id" :value="__('Gerencia') . ' (' . __('opcional') . ')'" />
                            <select id="gerencia_id" name="gerencia_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('Sin gerencia (área directa de dirección)') }}</option>
                                @foreach ($gerencias as $g)
                                    <option value="{{ $g->id }}" {{ old('gerencia_id', $area->gerencia_id) == $g->id ? 'selected' : '' }} data-direccion="{{ $g->direccion_id }}">{{ $g->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $area->nombre)" required />
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', $area->activo) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Activo') }}</span>
                            </label>
                        </div>
                        <div class="flex gap-4">
                            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                            <a href="{{ route('areas.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
