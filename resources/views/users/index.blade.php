<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios') }}
            </h2>
            @can('crear-usuarios')
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 w-full sm:w-auto">
                    {{ __('Nuevo Usuario') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    {{-- Vista móvil: Cards --}}
                    <div class="md:hidden space-y-4">
                        @forelse ($users as $user)
                            <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="space-y-2">
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600 break-all">{{ $user->email }}</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $role->name }}</span>
                                        @endforeach
                                        @if ($user->roles->isEmpty())
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100">
                                        @can('listar-usuarios')
                                            <a href="{{ route('users.show', $user) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">{{ __('Ver') }}</a>
                                        @endcan
                                        @can('editar-usuarios')
                                            <a href="{{ route('users.edit', $user) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">{{ __('Editar') }}</a>
                                        @endcan
                                        @can('eliminar-usuarios')
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este usuario?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium">{{ __('Eliminar') }}</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">{{ __('No hay usuarios registrados.') }}</p>
                        @endforelse
                    </div>

                    {{-- Vista desktop: Tabla --}}
                    <div class="hidden md:block overflow-x-auto -mx-4 sm:mx-0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Roles') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $user->email }}">{{ $user->email }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            @foreach ($user->roles as $role)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mr-1 mb-1">{{ $role->name }}</span>
                                            @endforeach
                                            @if ($user->roles->isEmpty())
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('listar-usuarios')
                                                <a href="{{ route('users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Ver') }}</a>
                                            @endcan
                                            @can('editar-usuarios')
                                                <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            @endcan
                                            @can('eliminar-usuarios')
                                                @if ($user->id !== auth()->id())
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este usuario?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay usuarios registrados.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-center sm:justify-start overflow-x-auto">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
