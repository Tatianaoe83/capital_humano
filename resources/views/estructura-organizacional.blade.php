<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Diagrama Interactivo de Estructura Organizacional') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Jerarquía: División → Unidad → Dirección → Gerencia → Área → Puesto. Los centros de costos se enlazan a una o más áreas.') }}
            </p>
        </div>
    </x-slot>

    @php
        $totales = [
            'divisiones' => $divisiones->count(),
            'unidades' => $divisiones->sum(fn ($division) => $division->unidadesNegocio->count()),
            'centros_costos' => $centrosCostoTotal,
            'direcciones' => $divisiones->sum(fn ($division) => $division->unidadesNegocio->sum(fn ($unidad) => $unidad->direcciones->count())),
            'gerencias' => $divisiones->sum(fn ($division) => $division->unidadesNegocio->sum(fn ($unidad) => $unidad->direcciones->sum(fn ($direccion) => $direccion->gerencias->count()))),
            'areas' => $divisiones->sum(fn ($division) => $division->unidadesNegocio->sum(fn ($unidad) => $unidad->direcciones->sum(fn ($direccion) => $direccion->areas->count() + $direccion->gerencias->sum(fn ($gerencia) => $gerencia->areas->count())))),
            'puestos' => $divisiones->sum(fn ($division) => $division->unidadesNegocio->sum(fn ($unidad) => $unidad->direcciones->sum(fn ($direccion) => $direccion->areas->sum(fn ($area) => $area->puestos->count()) + $direccion->gerencias->sum(fn ($gerencia) => $gerencia->areas->sum(fn ($area) => $area->puestos->count()))))),
        ];

        $graphNodes = [];
        $graphEdges = [];
        $seenNodeIds = [];
        $seenEdgeKeys = [];

        $pushNode = function (array $node) use (&$graphNodes, &$seenNodeIds) {
            if (isset($seenNodeIds[$node['id']])) {
                return;
            }

            $seenNodeIds[$node['id']] = true;
            $graphNodes[] = $node;
        };

        $pushEdge = function (string $from, string $to) use (&$graphEdges, &$seenEdgeKeys) {
            $edgeKey = $from.'->'.$to;

            if (isset($seenEdgeKeys[$edgeKey])) {
                return;
            }

            $seenEdgeKeys[$edgeKey] = true;
            $graphEdges[] = ['from' => $from, 'to' => $to];
        };

        foreach ($divisiones as $division) {
            $divisionId = 'division-'.$division->id;
            $pushNode([
                'id' => $divisionId,
                'label' => $division->nombre,
                'group' => 'division',
                'level' => 1,
                'type' => 'Division',
                'meta' => [
                    'nombre' => $division->nombre,
                    'detalle' => $division->unidadesNegocio->count().' unidades de negocio',
                ],
            ]);

            foreach ($division->unidadesNegocio as $unidad) {
                $unidadId = 'unidad-'.$unidad->id;
                $pushNode([
                    'id' => $unidadId,
                    'label' => $unidad->nombre,
                    'group' => 'unidad',
                    'level' => 2,
                    'type' => 'Unidad de negocio',
                    'meta' => [
                        'nombre' => $unidad->nombre,
                        'detalle' => $unidad->direcciones->count().' direcciones',
                        'padre' => $division->nombre,
                    ],
                ]);
                $pushEdge($divisionId, $unidadId);

                foreach ($unidad->direcciones as $direccion) {
                    $direccionId = 'direccion-'.$direccion->id;
                    $pushNode([
                        'id' => $direccionId,
                        'label' => $direccion->nombre,
                        'group' => 'direccion',
                        'level' => 4,
                        'type' => 'Direccion',
                        'meta' => [
                            'nombre' => $direccion->nombre,
                            'detalle' => $direccion->gerencias->count().' gerencias y '.$direccion->areas->count().' areas directas',
                            'padre' => $unidad->nombre,
                        ],
                    ]);
                    $pushEdge($unidadId, $direccionId);

                    foreach ($direccion->areas as $area) {
                        $areaId = 'area-'.$area->id;
                        $pushNode([
                            'id' => $areaId,
                            'label' => $area->nombre,
                            'group' => 'area',
                            'level' => 6,
                            'type' => 'Area',
                            'meta' => [
                                'nombre' => $area->nombre,
                                'detalle' => $area->puestos->count().' puestos',
                                'padre' => $direccion->nombre,
                            ],
                        ]);
                        $pushEdge($direccionId, $areaId);

                        foreach ($area->puestos as $puesto) {
                            $puestoId = 'puesto-'.$puesto->id;
                            $pushNode([
                                'id' => $puestoId,
                                'label' => $puesto->nombre,
                                'group' => 'puesto',
                                'level' => 7,
                                'type' => 'Puesto',
                                'meta' => [
                                    'nombre' => $puesto->nombre,
                                    'detalle' => 'Puesto registrado',
                                    'padre' => $area->nombre,
                                ],
                            ]);
                            $pushEdge($areaId, $puestoId);
                        }
                    }

                    foreach ($direccion->gerencias as $gerencia) {
                        $gerenciaId = 'gerencia-'.$gerencia->id;
                        $pushNode([
                            'id' => $gerenciaId,
                            'label' => $gerencia->nombre,
                            'group' => 'gerencia',
                            'level' => 5,
                            'type' => 'Gerencia',
                            'meta' => [
                                'nombre' => $gerencia->nombre,
                                'detalle' => $gerencia->areas->count().' areas',
                                'padre' => $direccion->nombre,
                            ],
                        ]);
                        $pushEdge($direccionId, $gerenciaId);

                        foreach ($gerencia->areas as $area) {
                            $areaId = 'area-'.$area->id;
                            $pushNode([
                                'id' => $areaId,
                                'label' => $area->nombre,
                                'group' => 'area',
                                'level' => 6,
                                'type' => 'Area',
                                'meta' => [
                                    'nombre' => $area->nombre,
                                    'detalle' => $area->puestos->count().' puestos',
                                    'padre' => $gerencia->nombre,
                                ],
                            ]);
                            $pushEdge($gerenciaId, $areaId);

                            foreach ($area->puestos as $puesto) {
                                $puestoId = 'puesto-'.$puesto->id;
                                $pushNode([
                                    'id' => $puestoId,
                                    'label' => $puesto->nombre,
                                    'group' => 'puesto',
                                    'level' => 7,
                                    'type' => 'Puesto',
                                    'meta' => [
                                        'nombre' => $puesto->nombre,
                                        'detalle' => 'Puesto registrado',
                                        'padre' => $area->nombre,
                                    ],
                                ]);
                                $pushEdge($areaId, $puestoId);
                            }
                        }
                    }
                }

                foreach (($centrosPorUnidad[$unidad->id] ?? []) as $centroCosto) {
                    $centroCostoId = 'centro-costo-'.$centroCosto->id;
                    $pushNode([
                        'id' => $centroCostoId,
                        'label' => $centroCosto->nombre,
                        'group' => 'centro_costo',
                        'level' => 3,
                        'type' => 'Centro de costos',
                        'meta' => [
                            'nombre' => $centroCosto->nombre,
                            'detalle' => $centroCosto->areas->count().' áreas vinculadas',
                            'padre' => $unidad->nombre,
                        ],
                    ]);
                    $pushEdge($unidadId, $centroCostoId);

                    foreach ($centroCosto->areas as $area) {
                        $pushEdge($centroCostoId, 'area-'.$area->id);
                    }
                }
            }
        }
    @endphp

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Divisiones') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totales['divisiones'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Unidades de negocio') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totales['unidades'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Direcciones') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totales['direcciones'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Centros de costos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totales['centros_costos'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">{{ __('Organigrama interactivo') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ __('Arrastra, usa zoom y haz clic en un nodo para ver detalles.') }}</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <label class="relative block">
                                <span class="sr-only">{{ __('Buscar nodo') }}</span>
                                <input id="org-search" type="search" placeholder="{{ __('Buscar unidad, centro de costos o puesto...') }}"
                                    class="block w-full rounded-lg border-slate-300 py-2 pl-3 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">⌕</span>
                            </label>
                            <button id="org-reset" type="button"
                                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                {{ __('Recentrar') }}
                            </button>
                        </div>
                    </div>
                    <div id="org-chart" class="h-[70vh] min-h-[560px] w-full rounded-b-xl"></div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h3 class="text-base font-semibold text-slate-900">{{ __('Detalle del nodo') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ __('Selecciona un elemento del diagrama.') }}</p>
                        </div>
                        <div class="space-y-4 p-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600" id="org-node-type">{{ __('Sin selección') }}</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900" id="org-node-name">{{ __('Explora la estructura') }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Descripción') }}</p>
                                <p class="mt-1 text-sm font-medium text-slate-800" id="org-node-detail">{{ __('Haz clic en cualquier nodo para ver su contexto y su relación jerárquica.') }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ __('Depende de') }}</p>
                                <p class="mt-1 text-sm font-medium text-slate-800" id="org-node-parent">—</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h3 class="text-base font-semibold text-slate-900">{{ __('Niveles') }}</h3>
                        </div>
                        <div class="space-y-3 p-5 text-sm text-slate-600">
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-indigo-500"></span>{{ __('Division') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-blue-500"></span>{{ __('Unidad de negocio') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-cyan-500"></span>{{ __('Centro de costos') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-emerald-500"></span>{{ __('Direccion') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-amber-500"></span>{{ __('Gerencia') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-slate-500"></span>{{ __('Area') }}</div>
                            <div class="flex items-center gap-3"><span class="h-3 w-3 rounded-full bg-rose-500"></span>{{ __('Puesto') }}</div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h3 class="text-base font-semibold text-slate-900">{{ __('Resumen') }}</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-3 p-5 text-sm">
                            <div class="rounded-lg bg-slate-50 p-3">
                                <p class="text-slate-500">{{ __('Centros de costos') }}</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">{{ $totales['centros_costos'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-3">
                                <p class="text-slate-500">{{ __('Gerencias') }}</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">{{ $totales['gerencias'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-3">
                                <p class="text-slate-500">{{ __('Areas') }}</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">{{ $totales['areas'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-3">
                                <p class="text-slate-500">{{ __('Puestos') }}</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">{{ $totales['puestos'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-3 col-span-2">
                                <p class="text-slate-500">{{ __('Nodos totales en el mapa') }}</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">{{ count($graphNodes) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const initOrgChart = () => {
            const container = document.getElementById('org-chart');

            if (!container) {
                return;
            }

            const visNetwork = window.visNetwork;

            if (!visNetwork) {
                container.innerHTML = '<div class="flex h-full items-center justify-center px-4 text-center text-sm text-rose-500">{{ __('No fue posible cargar la libreria del organigrama.') }}</div>';
                return;
            }

            const rawNodes = @json($graphNodes);
            const rawEdges = @json($graphEdges);

            if (!rawNodes.length) {
                container.innerHTML = '<div class="flex h-full items-center justify-center text-sm text-slate-500">{{ __('No hay estructura organizacional registrada todavia.') }}</div>';
                return;
            }

            const nodeMap = new Map(rawNodes.map((node) => [node.id, node]));
            const edgeMap = new Map(rawEdges.map((edge) => [edge.to, edge.from]));

            const nodes = new visNetwork.DataSet(rawNodes.map((node) => ({
                ...node,
                shape: 'box',
                margin: 12,
                font: {
                    face: 'Figtree, sans-serif',
                    color: '#0f172a',
                    size: 14,
                    bold: node.level <= 2,
                },
                borderWidth: 1.5,
                borderRadius: 12,
            })));

            const edges = new visNetwork.DataSet(rawEdges.map((edge) => ({
                ...edge,
                color: { color: '#cbd5e1', highlight: '#6366f1' },
                smooth: {
                    type: 'cubicBezier',
                    forceDirection: 'vertical',
                    roundness: 0.4,
                },
            })));

            const network = new visNetwork.Network(container, { nodes, edges }, {
                autoResize: true,
                interaction: {
                    dragNodes: true,
                    dragView: true,
                    zoomView: true,
                    hover: true,
                    navigationButtons: true,
                },
                layout: {
                    hierarchical: {
                        enabled: true,
                        direction: 'UD',
                        sortMethod: 'directed',
                        levelSeparation: 110,
                        nodeSpacing: 175,
                        treeSpacing: 210,
                        shakeTowards: 'roots',
                    },
                },
                physics: false,
                groups: {
                    division: { color: { background: '#e0e7ff', border: '#6366f1' } },
                    unidad: { color: { background: '#dbeafe', border: '#3b82f6' } },
                    centro_costo: { color: { background: '#cffafe', border: '#06b6d4' } },
                    direccion: { color: { background: '#d1fae5', border: '#10b981' } },
                    gerencia: { color: { background: '#fef3c7', border: '#f59e0b' } },
                    area: { color: { background: '#e2e8f0', border: '#64748b' } },
                    puesto: { color: { background: '#ffe4e6', border: '#f43f5e' } },
                },
            });

            const typeEl = document.getElementById('org-node-type');
            const nameEl = document.getElementById('org-node-name');
            const detailEl = document.getElementById('org-node-detail');
            const parentEl = document.getElementById('org-node-parent');
            const searchInput = document.getElementById('org-search');
            const resetBtn = document.getElementById('org-reset');

            const updateDetail = (nodeId) => {
                const node = nodeMap.get(nodeId);

                if (!node) {
                    typeEl.textContent = '{{ __('Sin selección') }}';
                    nameEl.textContent = '{{ __('Explora la estructura') }}';
                    detailEl.textContent = '{{ __('Haz clic en cualquier nodo para ver su contexto y su relación jerárquica.') }}';
                    parentEl.textContent = '—';
                    return;
                }

                typeEl.textContent = node.type;
                nameEl.textContent = node.meta.nombre;
                detailEl.textContent = node.meta.detalle;
                parentEl.textContent = node.meta.padre ?? '—';
            };

            network.on('click', (params) => {
                updateDetail(params.nodes[0] ?? null);
            });

            searchInput?.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter') {
                    return;
                }

                event.preventDefault();

                const term = searchInput.value.trim().toLowerCase();
                if (!term) {
                    network.fit({ animation: true });
                    updateDetail(null);
                    return;
                }

                const found = rawNodes.find((node) => node.label.toLowerCase().includes(term));

                if (!found) {
                    detailEl.textContent = '{{ __('No se encontro un nodo con ese criterio de busqueda.') }}';
                    return;
                }

                network.selectNodes([found.id]);
                network.focus(found.id, {
                    scale: 1,
                    animation: {
                        duration: 700,
                        easingFunction: 'easeInOutQuad',
                    },
                });
                updateDetail(found.id);
            });

            resetBtn?.addEventListener('click', () => {
                network.fit({ animation: true });
                network.unselectAll();
                if (searchInput) {
                    searchInput.value = '';
                }
                updateDetail(null);
            });

            updateDetail(rawNodes[0]?.id ?? null);
            network.once('afterDrawing', () => network.fit({ animation: false }));
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initOrgChart, { once: true });
        } else {
            initOrgChart();
        }
    </script>
</x-app-layout>
