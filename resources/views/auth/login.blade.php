<x-auth-split-layout>
    <header class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">{{ __('Bienvenido de nuevo') }}</h1>
        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
            {{ __('Ingrese con su cuenta corporativa para acceder al panel de administración.') }}
        </p>
    </header>

    <x-auth-session-status class="mb-5 p-3 rounded-lg bg-amber-50 border border-amber-100 text-amber-900 text-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" class="text-slate-700 font-medium text-sm">
                {{ __('Correo electrónico') }} <span class="text-red-500" aria-hidden="true">*</span>
            </x-input-label>
            <x-text-input
                id="email"
                class="block mt-2 w-full rounded-lg border-slate-300 shadow-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="{{ __('correo@empresa.com') }}"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" class="text-slate-700 font-medium text-sm">
                {{ __('Contraseña') }} <span class="text-red-500" aria-hidden="true">*</span>
            </x-input-label>
            <div class="relative mt-2">
                <x-text-input
                    id="password"
                    class="block w-full pr-11 rounded-lg border-slate-300 shadow-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Introduzca su contraseña') }}"
                />
                <button
                    type="button"
                    id="toggle-password"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none focus:text-slate-700"
                    aria-label="{{ __('Mostrar u ocultar contraseña') }}"
                >
                    <svg id="icon-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="icon-eye-off" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-800 shadow-sm focus:ring-slate-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Recordarme en este equipo') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-slate-700 hover:text-slate-900 underline-offset-2 hover:underline shrink-0" href="{{ route('password.request') }}">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="w-full flex justify-center items-center px-4 py-3 rounded-lg font-semibold text-sm text-white bg-slate-800 border border-transparent hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition"
        >
            {{ __('Iniciar sesión') }}
        </button>
    </form>

  

    <script>
        (function () {
            var btn = document.getElementById('toggle-password');
            var input = document.getElementById('password');
            var eye = document.getElementById('icon-eye');
            var eyeOff = document.getElementById('icon-eye-off');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                if (eye && eyeOff) {
                    eye.classList.toggle('hidden', show);
                    eyeOff.classList.toggle('hidden', !show);
                }
            });
        })();
    </script>
</x-auth-split-layout>
