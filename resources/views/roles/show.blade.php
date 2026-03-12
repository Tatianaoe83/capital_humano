<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle Rol') }}: {{ $role->name }}
            </h2>
            @can('editar-roles')
                <a href="{{ route('roles.edit', $role) }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 w-full sm:w-auto">
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
                            <dt class="text-sm font-medium text-gray-500">{{ __('Permisos') }}</dt>
                            <dd class="mt-2 flex flex-wrap gap-2">
                                @foreach ($role->permissions as $permission)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $permission->name }}</span>
                                @endforeach
                                @if ($role->permissions->isEmpty())
                                    <span class="text-gray-400">-</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Usuarios con este rol') }}</dt>
                            <dd class="mt-2 flex flex-wrap gap-2">
                                @foreach ($role->users as $user)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $user->name }}</span>
                                @endforeach
                                @if ($role->users->isEmpty())
                                    <span class="text-gray-400">-</span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <a href="{{ route('roles.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Volver a la lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
