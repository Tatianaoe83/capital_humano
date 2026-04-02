<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Centro de Costos') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('centros-costos.update', $centroCosto) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Centro de Costos')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $centroCosto->nombre)" required />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>
                        @include('catalogos.centros-costos.partials.area-selector', ['selectedAreaIds' => old('area_ids', $centroCosto->areas->pluck('id')->all())])
                        <div class="mb-4 mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', $centroCosto->activo) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Activo') }}</span>
                            </label>
                        </div>
                        <div class="flex gap-4">
                            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                            <a href="{{ route('centros-costos.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
