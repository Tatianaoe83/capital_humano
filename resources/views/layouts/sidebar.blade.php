<div x-data="{ sidebarOpen: true, adminOpen: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}, mobileMenuOpen: false }" class="flex h-screen bg-slate-100 overflow-hidden">
    <!-- Botón menú móvil -->
    <button @click="mobileMenuOpen = true" class="lg:hidden fixed top-4 left-4 z-40 p-2 rounded-lg bg-slate-800 text-white shadow-lg hover:bg-slate-700 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <!-- Overlay móvil -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false; $dispatch('close-mobile-menu')" x-transition class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display: none;"></div>
    <!-- Sidebar Vertical - Desktop: siempre visible | Móvil: overlay drawer -->
    <aside class="flex flex-col bg-slate-800 border-r border-slate-700/50 shadow-xl shrink-0
                  fixed lg:relative inset-y-0 left-0 z-50 lg:z-auto
                  w-64 transition-transform duration-300 lg:transition-[width] lg:duration-300
                  -translate-x-full lg:translate-x-0"
           :class="{ 'translate-x-0': mobileMenuOpen, 'lg:w-20': !sidebarOpen, 'lg:w-64': sidebarOpen }">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-slate-700/50 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-700/50 shrink-0">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150" class="font-bold text-white text-lg whitespace-nowrap">Capital Humano</span>
            </a>
            <button @click="sidebarOpen = ! sidebarOpen" class="p-2 rounded-lg text-slate-400 hover:bg-slate-700/50 hover:text-white transition-colors shrink-0">
                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': !sidebarOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>

        <!-- Menu vertical con collapse -->
        <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-3">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('dashboard') ? 'bg-slate-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap overflow-hidden">{{ __('Dashboard') }}</span>
            </a>

            <!-- Administración - Collapse -->
            @if(auth()->user()->can('listar-usuarios') || auth()->user()->can('listar-roles') || auth()->user()->can('listar-permisos'))
                <div>
                    <button @click="adminOpen = ! adminOpen" class="flex items-center justify-between w-full gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200
                        {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'bg-slate-700/50 text-white' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                        <span class="flex items-center gap-3 min-w-0">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap overflow-hidden">{{ __('Administración') }}</span>
                        </span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': adminOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Submenu collapse -->
                    <div x-show="adminOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         class="overflow-hidden">
                        <div class="pl-4 mt-1 space-y-0.5 border-l border-slate-600/50 ml-5">
                                @can('listar-usuarios')
                                <a href="{{ route('users.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all
                                    {{ request()->routeIs('users.*') ? 'bg-slate-600/80 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z" />
                                    </svg>
                                    <span x-show="sidebarOpen" x-transition>{{ __('Usuarios') }}</span>
                                </a>
                            @endcan
                                @can('listar-roles')
                                <a href="{{ route('roles.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all
                                    {{ request()->routeIs('roles.*') ? 'bg-slate-600/80 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span x-show="sidebarOpen" x-transition>{{ __('Roles') }}</span>
                                </a>
                            @endcan
                                @can('listar-permisos')
                                <a href="{{ route('permissions.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all
                                    {{ request()->routeIs('permissions.*') ? 'bg-slate-600/80 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span x-show="sidebarOpen" x-transition>{{ __('Permisos') }}</span>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Usuario - Parte inferior -->
        <div class="p-3 border-t border-slate-700/50 shrink-0" x-data="{ userOpen: false }">
            <div @click="userOpen = ! userOpen" class="flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer bg-slate-700/30 hover:bg-slate-700/50 transition-colors">
                <div class="w-9 h-9 rounded-full bg-slate-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" class="min-w-0 flex-1 overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->getRoleNames()->first() ?? 'Usuario' }}</p>
                </div>
                <svg x-show="sidebarOpen" class="w-4 h-4 text-slate-400 shrink-0 transition-transform" :class="{ 'rotate-180': userOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <!-- Dropdown usuario -->
            <div x-show="userOpen" x-transition
                 @click.outside="userOpen = false"
                 class="mt-2 py-2 bg-slate-700/30 rounded-lg overflow-hidden">
                <a href="{{ route('profile.edit') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>{{ __('Perfil') }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-red-400 hover:bg-red-900/20 transition-colors text-left">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>{{ __('Cerrar Sesión') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden pl-14 lg:pl-0">
        @isset($header)
            <header class="bg-white shadow-sm border-b border-slate-200/60 shrink-0">
                <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 pt-16 lg:pt-4">
            {{ $slot }}
        </main>
    </div>
</div>
