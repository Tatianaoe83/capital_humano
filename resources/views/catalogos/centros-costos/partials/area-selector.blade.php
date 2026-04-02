@php
    $selectedAreaIds = collect($selectedAreaIds ?? old('area_ids', []))->map(fn ($id) => (int) $id)->all();
@endphp

<div id="cc-area-selector" class="space-y-3">
    <x-input-label :value="__('Áreas vinculadas')" />
    <p class="text-xs text-gray-500">{{ __('Filtre la lista y use los botones para marcar varias áreas o todas las de una gerencia.') }}</p>

    <div class="flex flex-wrap gap-2 items-end">
        <div class="min-w-[10rem] flex-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('División') }}</label>
            <select id="cc_filter_division" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Todas') }}</option>
                @foreach ($divisiones as $div)
                    <option value="{{ $div->id }}">{{ $div->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[10rem] flex-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('Unidad de negocio') }}</label>
            <select id="cc_filter_unidad" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Todas') }}</option>
                @foreach ($unidadesNegocio as $unidad)
                    <option value="{{ $unidad->id }}" data-division="{{ $unidad->division_id }}">{{ $unidad->division->nombre }} / {{ $unidad->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[10rem] flex-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('Gerencia (filtro)') }}</label>
            <select id="cc_filter_gerencia" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Todas') }}</option>
                <option value="__direct__">{{ __('Solo áreas sin gerencia') }}</option>
                @foreach ($gerencias as $gerencia)
                    <option value="{{ $gerencia->id }}" data-unidad="{{ $gerencia->direccion->unidad_negocio_id }}">{{ $gerencia->direccion->unidadNegocio->division->nombre }} / {{ $gerencia->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[12rem] flex-[2]">
            <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('Buscar') }}</label>
            <input type="search" id="cc_filter_search" placeholder="{{ __('Nombre de área o ruta…') }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="off">
        </div>
    </div>

    <div class="flex flex-wrap gap-2 items-center">
        <button type="button" id="cc_btn_select_visible" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wide hover:bg-indigo-700">
            {{ __('Seleccionar visibles') }}
        </button>
        <button type="button" id="cc_btn_deselect_all" class="inline-flex items-center px-3 py-1.5 bg-gray-700 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wide hover:bg-gray-800">
            {{ __('Deseleccionar todas') }}
        </button>
        <span id="cc_selected_count" class="text-xs text-gray-600 px-2 py-1 bg-gray-100 rounded-md"></span>
    </div>

    <div class="flex flex-wrap gap-2 items-end border-t border-gray-200 pt-3">
        <div class="min-w-[14rem] flex-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('Gerencia (marcar todas sus áreas)') }}</label>
            <select id="cc_bulk_gerencia" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Elija una gerencia…') }}</option>
                @foreach ($gerencias as $gerencia)
                    <option value="{{ $gerencia->id }}">{{ $gerencia->direccion->unidadNegocio->division->nombre }} / {{ $gerencia->direccion->unidadNegocio->nombre }} / {{ $gerencia->direccion->nombre }} / {{ $gerencia->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" id="cc_btn_bulk_gerencia" class="inline-flex items-center px-3 py-2 bg-sky-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wide hover:bg-sky-700">
            {{ __('Marcar todas de esta gerencia') }}
        </button>
        <button type="button" id="cc_btn_bulk_direct" class="inline-flex items-center px-3 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wide hover:bg-teal-700">
            {{ __('Marcar todas sin gerencia') }}
        </button>
    </div>

    <div class="max-h-72 overflow-y-auto rounded-md border border-gray-200 bg-gray-50/50 p-2 space-y-1">
        @foreach ($areas as $area)
            @php
                $div = $area->direccion->unidadNegocio->division;
                $unidad = $area->direccion->unidadNegocio;
                $dir = $area->direccion;
                $ger = $area->gerencia;
                $path = $div->nombre.' / '.$unidad->nombre.' / '.$dir->nombre.($ger ? ' / '.$ger->nombre : '').' / '.$area->nombre;
                $search = mb_strtolower($path, 'UTF-8');
            @endphp
            <label
                class="cc-area-row flex items-start gap-2 rounded px-2 py-1.5 hover:bg-white cursor-pointer text-sm"
                data-division="{{ $div->id }}"
                data-unidad="{{ $unidad->id }}"
                data-gerencia="{{ $area->gerencia_id ?? '' }}"
                data-search="{{ e($search) }}"
            >
                <input
                    type="checkbox"
                    name="area_ids[]"
                    value="{{ $area->id }}"
                    class="cc-area-cb mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    {{ in_array((int) $area->id, $selectedAreaIds, true) ? 'checked' : '' }}
                >
                <span class="text-gray-800">{{ $path }}</span>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('area_ids')" class="mt-2" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.getElementById('cc-area-selector');
        if (!root) return;

        const fDiv = root.querySelector('#cc_filter_division');
        const fUnidad = root.querySelector('#cc_filter_unidad');
        const fGerencia = root.querySelector('#cc_filter_gerencia');
        const fSearch = root.querySelector('#cc_filter_search');
        const bulkGerencia = root.querySelector('#cc_bulk_gerencia');
        const countEl = root.querySelector('#cc_selected_count');
        const suffix = @json(__('áreas seleccionadas'));
        const rows = () => Array.from(root.querySelectorAll('.cc-area-row'));

        function syncUnidadOptionsByDivision() {
            const d = fDiv.value;
            Array.from(fUnidad.querySelectorAll('option[data-division]')).forEach(function (opt) {
                if (!d) {
                    opt.hidden = false;
                    return;
                }
                opt.hidden = opt.getAttribute('data-division') !== d;
            });
            const sel = fUnidad.selectedOptions[0];
            if (sel && sel.hidden) {
                fUnidad.value = '';
            }
        }

        function applyFilters() {
            const d = fDiv.value;
            const u = fUnidad.value;
            const g = fGerencia.value;
            const q = (fSearch.value || '').trim().toLowerCase();

            rows().forEach(function (row) {
                let show = true;
                if (d && row.getAttribute('data-division') !== d) show = false;
                if (u && row.getAttribute('data-unidad') !== u) show = false;
                if (g === '__direct__') {
                    if (row.getAttribute('data-gerencia') !== '') show = false;
                } else if (g && row.getAttribute('data-gerencia') !== g) show = false;
                if (q) {
                    const hay = row.getAttribute('data-search') || '';
                    if (!hay.includes(q)) show = false;
                }
                row.classList.toggle('hidden', !show);
            });
        }

        function updateCount() {
            const n = root.querySelectorAll('.cc-area-cb:checked').length;
            countEl.textContent = n + ' ' + suffix;
        }

        fDiv.addEventListener('change', function () {
            syncUnidadOptionsByDivision();
            applyFilters();
        });
        fUnidad.addEventListener('change', applyFilters);
        fGerencia.addEventListener('change', applyFilters);
        fSearch.addEventListener('input', applyFilters);

        root.querySelector('#cc_btn_select_visible').addEventListener('click', function () {
            rows().forEach(function (row) {
                if (row.classList.contains('hidden')) return;
                const cb = row.querySelector('.cc-area-cb');
                if (cb) cb.checked = true;
            });
            updateCount();
        });

        root.querySelector('#cc_btn_deselect_all').addEventListener('click', function () {
            root.querySelectorAll('.cc-area-cb').forEach(function (cb) {
                cb.checked = false;
            });
            updateCount();
        });

        root.querySelector('#cc_btn_bulk_gerencia').addEventListener('click', function () {
            const gid = bulkGerencia.value;
            if (!gid) return;
            rows().forEach(function (row) {
                if (row.getAttribute('data-gerencia') === gid) {
                    row.querySelector('.cc-area-cb').checked = true;
                }
            });
            updateCount();
        });

        root.querySelector('#cc_btn_bulk_direct').addEventListener('click', function () {
            rows().forEach(function (row) {
                if (row.getAttribute('data-gerencia') === '') {
                    row.querySelector('.cc-area-cb').checked = true;
                }
            });
            updateCount();
        });

        root.querySelectorAll('.cc-area-cb').forEach(function (cb) {
            cb.addEventListener('change', updateCount);
        });

        syncUnidadOptionsByDivision();
        applyFilters();
        updateCount();
    });
</script>
