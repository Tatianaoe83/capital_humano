<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Capital Humano') }} — Acceso</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased text-slate-900" style="font-family: 'Inter', system-ui, sans-serif;">
        <div class="min-h-screen flex flex-col lg:flex-row">
            {{-- Panel formulario --}}
            <div class="flex-1 flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16 xl:px-24 bg-white">
                <div class="w-full max-w-md mx-auto lg:mx-0">
                    <a href="{{ url('/') }}" class="inline-block mb-10 hover:opacity-90 transition-opacity focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2 rounded">
                        <img
                            src="{{ asset('img/logo.png') }}"
                            alt="{{ config('app.name', 'Capital Humano') }}"
                            class="h-10 sm:h-12 w-auto max-w-[min(100%,280px)] object-contain object-left"
                        />
                    </a>

                    {{ $slot }}

                    <!--<p class="mt-12 text-center text-xs text-slate-400 lg:text-left">
                        © {{ date('Y') }} {{ config('app.name', 'Capital Humano') }}. {{ __('Todos los derechos reservados.') }}
                    </p>-->
                </div>
            </div>

            {{-- Panel visual corporativo --}}
            <div class="hidden lg:flex lg:flex-1 relative overflow-hidden bg-slate-900">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-[#0f172a] to-[#0c1929]"></div>
                <div class="absolute inset-0 opacity-[0.07]" style="background-image: linear-gradient(rgba(255,255,255,.4) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.4) 1px, transparent 1px); background-size: 48px 48px;"></div>
                <div class="absolute top-0 right-0 w-[min(55%,420px)] h-[min(55%,420px)] rounded-full bg-slate-700/25 blur-3xl -translate-y-1/4 translate-x-1/4"></div>
                <div class="absolute bottom-0 left-0 w-[min(50%,360px)] h-[min(50%,360px)] rounded-full bg-slate-600/15 blur-3xl translate-y-1/4 -translate-x-1/4"></div>

                <div class="relative z-10 flex flex-col justify-center px-14 xl:px-20 text-white">
                    <div class="max-w-md">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-4">{{ __('Panel administrativo') }}</p>
                        <h2 class="text-3xl xl:text-4xl font-semibold tracking-tight text-white leading-tight">
                            {{ __('Gestión integral de capital humano') }}
                        </h2>
                        <p class="mt-5 text-sm leading-relaxed text-slate-400">
                            {{ __('Acceso seguro para equipos de administración. Sus datos permanecen protegidos y auditables.') }}
                        </p>
                        <ul class="mt-8 space-y-3 text-sm text-slate-300">
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                                {{ __('Estructura organizacional y catálogos centralizados') }}
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                                {{ __('Sesiones cifradas y buenas prácticas de acceso') }}
                            </li>
                        </ul>
                    </div>

                    {{-- Patrón geométrico sobrio --}}
                    <div class="absolute bottom-10 right-10 xl:bottom-14 xl:right-16 opacity-[0.12] pointer-events-none" aria-hidden="true">
                        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="20" y="20" width="80" height="80" rx="4" stroke="white" stroke-width="1"/>
                            <rect x="100" y="100" width="80" height="80" rx="4" stroke="white" stroke-width="1"/>
                            <circle cx="160" cy="40" r="28" stroke="white" stroke-width="1"/>
                            <path d="M20 180 L100 100" stroke="white" stroke-width="1"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
