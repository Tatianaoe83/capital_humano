<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Centros de Costos') }}
            </h2>
            <a href="{{ route('centros-costos.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 w-full sm:w-auto">
                {{ __('Nuevo Centro de Costos') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <div class="mb-4">
                <form method="GET" class="flex flex-wrap gap-2 items-end">
                    <select name="division_id" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm max-w-xs" onchange="this.form.submit()">
                        <option value="">{{ __('Todas las divisiones') }}</option>
                        @foreach ($divisiones as $div)
                            <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>{{ $div->nombre }}</option>
                        @endforeach
                    </select>
                    <select name="unidad_negocio_id" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm max-w-xs" onchange="this.form.submit()">
                        <option value="">{{ __('Todas las unidades') }}</option>
                        @foreach ($unidadesNegocio as $unidad)
                            <option value="{{ $unidad->id }}" {{ request('unidad_negocio_id') == $unidad->id ? 'selected' : '' }}>{{ $unidad->division->nombre }} / {{ $unidad->nombre }}</option>
                        @endforeach
                    </select>
                    <select name="gerencia_id" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm max-w-xs" onchange="this.form.submit()">
                        <option value="">{{ __('Todas las gerencias') }}</option>
                        @foreach ($gerencias as $gerencia)
                            <option value="{{ $gerencia->id }}" {{ request('gerencia_id') == $gerencia->id ? 'selected' : '' }}>{{ $gerencia->direccion->unidadNegocio->division->nombre }} / {{ $gerencia->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('Buscar por nombre…') }}" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm min-w-[12rem]">
                    <button type="submit" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium hover:bg-gray-300">{{ __('Filtrar') }}</button>
                    @if (request()->hasAny(['division_id', 'unidad_negocio_id', 'gerencia_id', 'q']))
                        <a href="{{ route('centros-costos.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900">{{ __('Limpiar') }}</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Centro de Costos') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Áreas vinculadas') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($centrosCostos as $centroCosto)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 text-sm font-medium text-gray-900">{{ $centroCosto->nombre }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">{{ $centroCosto->areas_count }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $centroCosto->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $centroCosto->activo ? __('Activo') : __('Inactivo') }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('centros-costos.edit', $centroCosto) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            <form action="{{ route('centros-costos.destroy', $centroCosto) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay centros de costos.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $centrosCostos->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
