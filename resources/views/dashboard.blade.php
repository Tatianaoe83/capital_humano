<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-200/60">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-emerald-100 text-emerald-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ __('¡Bienvenido!') }}</h3>
                            <p class="text-slate-600">{{ __("Has iniciado sesión correctamente en el sistema de Capital Humano.") }}</p>
                        </div>
                    </div>
                    <p class="text-sm sm:text-base text-slate-600">{{ __('Utiliza el menú de navegación lateral para acceder a Usuarios, Roles y Permisos.') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
