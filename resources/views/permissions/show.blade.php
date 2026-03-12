<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle Permiso') }}: {{ $permission->name }}
            </h2>
            @can('editar-permisos')
                <a href="{{ route('permissions.edit', $permission) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Editar') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Nombre') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permission->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Cantidad de roles') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permission->roles_count }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <a href="{{ route('permissions.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Volver a la lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
