<x-guest-layout>
    <h2 class="text-lg font-semibold text-slate-800 mb-6">{{ __('Iniciar Sesión') }}</h2>

    <x-auth-session-status class="mb-4 p-3 rounded-lg bg-amber-50 text-amber-800 text-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-slate-700 font-medium" />
            <x-text-input id="email" class="block mt-2 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@ejemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Contraseña -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-slate-700 font-medium" />
            <x-text-input id="password" class="block mt-2 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-600 shadow-sm focus:ring-slate-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Recordarme') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-600 hover:text-slate-900 focus:outline-none focus:underline" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-slate-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition">
            {{ __('Iniciar Sesión') }}
        </button>
    </form>
</x-guest-layout>
