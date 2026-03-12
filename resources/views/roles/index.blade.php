<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            @can('crear-roles')
                <a href="{{ route('roles.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 w-full sm:w-auto">
                    {{ __('Nuevo Rol') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 text-sm sm:text-base">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    {{-- Vista móvil: Cards --}}
                    <div class="md:hidden space-y-4">
                        @forelse ($roles as $role)
                            <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="space-y-2">
                                    <p class="font-semibold text-gray-900">{{ $role->name }}</p>
                                    <p class="text-sm text-gray-600">{{ __('Usuarios') }}: {{ $role->users_count }}</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($role->permissions->take(5) as $permission)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $permission->name }}</span>
                                        @endforeach
                                        @if ($role->permissions->count() > 5)
                                            <span class="text-gray-500 text-xs">+{{ $role->permissions->count() - 5 }}</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100">
                                        @can('listar-roles')
                                            <a href="{{ route('roles.show', $role) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">{{ __('Ver') }}</a>
                                        @endcan
                                        @can('editar-roles')
                                            <a href="{{ route('roles.edit', $role) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">{{ __('Editar') }}</a>
                                        @endcan
                                        @can('eliminar-roles')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este rol?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium">{{ __('Eliminar') }}</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">{{ __('No hay roles registrados.') }}</p>
                        @endforelse
                    </div>

                    {{-- Vista desktop: Tabla --}}
                    <div class="hidden md:block overflow-x-auto -mx-4 sm:mx-0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Usuarios') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Permisos') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($roles as $role)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $role->name }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $role->users_count }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            @foreach ($role->permissions->take(3) as $permission)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mr-1 mb-1">{{ $permission->name }}</span>
                                            @endforeach
                                            @if ($role->permissions->count() > 3)
                                                <span class="text-gray-400">+{{ $role->permissions->count() - 3 }} más</span>
                                            @endif
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('listar-roles')
                                                <a href="{{ route('roles.show', $role) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Ver') }}</a>
                                            @endcan
                                            @can('editar-roles')
                                                <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            @endcan
                                            @can('eliminar-roles')
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este rol?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay roles registrados.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-center sm:justify-start overflow-x-auto">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
