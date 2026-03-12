<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permisos') }}
            </h2>
            @can('crear-permisos')
                <a href="{{ route('permissions.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 w-full sm:w-auto">
                    {{ __('Nuevo Permiso') }}
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
                        @forelse ($permissions as $permission)
                            <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <p class="font-semibold text-gray-900">{{ $permission->name }}</p>
                                    <p class="text-sm text-gray-600">{{ __('Roles') }}: {{ $permission->roles_count }}</p>
                                    <div class="flex gap-2 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                        @can('editar-permisos')
                                            <a href="{{ route('permissions.edit', $permission) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">{{ __('Editar') }}</a>
                                        @endcan
                                        @can('eliminar-permisos')
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este permiso?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium">{{ __('Eliminar') }}</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">{{ __('No hay permisos registrados.') }}</p>
                        @endforelse
                    </div>

                    {{-- Vista desktop: Tabla --}}
                    <div class="hidden md:block overflow-x-auto -mx-4 sm:mx-0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Roles') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $permission->name }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $permission->roles_count }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('editar-permisos')
                                                <a href="{{ route('permissions.edit', $permission) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            @endcan
                                            @can('eliminar-permisos')
                                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este permiso?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay permisos registrados.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-center sm:justify-start overflow-x-auto">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
