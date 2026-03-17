<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Empleados') }}
            </h2>
            <a href="{{ route('empleados.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 w-full sm:w-auto">
                {{ __('Nuevo Empleado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre completo') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Puesto') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Jefe inmediato') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha ingreso') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($empleados as $e)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $e->apellido_paterno }} {{ $e->apellido_materno }} {{ $e->nombre }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            {{ $e->puesto?->nombre ?? '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                            {{ $e->jefeInmediato ? $e->jefeInmediato->apellido_paterno . ' ' . $e->jefeInmediato->apellido_materno . ' ' . $e->jefeInmediato->nombre : '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $e->fecha_ingreso?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('empleados.edit', $e) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            <form action="{{ route('empleados.destroy', $e) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar este empleado?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay empleados registrados.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $empleados->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
