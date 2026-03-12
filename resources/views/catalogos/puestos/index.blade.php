<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Puestos') }}
            </h2>
            <a href="{{ route('puestos.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 w-full sm:w-auto">
                {{ __('Nuevo Puesto') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('catalogos.partials.messages')

            <div class="mb-4">
                <form method="GET" class="flex flex-wrap gap-2">
                    <select name="area_id" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 text-sm" onchange="this.form.submit()">
                        <option value="">{{ __('Todas las áreas') }}</option>
                        @foreach ($areas as $a)
                            <option value="{{ $a->id }}" {{ request('area_id') == $a->id ? 'selected' : '' }}>{{ $a->direccion->nombre }} / {{ $a->nombre }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Área') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($puestos as $p)
                                    <tr>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">{{ $p->area->direccion->nombre }} / {{ $p->area->nombre }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->nombre }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $p->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $p->activo ? __('Activo') : __('Inactivo') }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('puestos.edit', $p) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('Editar') }}</a>
                                            <form action="{{ route('puestos.destroy', $p) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-gray-500">{{ __('No hay puestos.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $puestos->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
