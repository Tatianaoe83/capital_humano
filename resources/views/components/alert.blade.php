@props([
    'type' => 'success', // success | error | warning | info
    'message' => '',
    'dismissible' => true,
    'autodismiss' => false,
    'autodismissSeconds' => 5,
])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'text' => 'text-emerald-800',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'iconBg' => 'bg-emerald-100',
            'iconColor' => 'text-emerald-600',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800',
            'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'iconBg' => 'bg-red-100',
            'iconColor' => 'text-red-600',
        ],
        'warning' => [
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'text' => 'text-amber-800',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            'iconBg' => 'bg-amber-100',
            'iconColor' => 'text-amber-600',
        ],
        'info' => [
            'bg' => 'bg-sky-50',
            'border' => 'border-sky-200',
            'text' => 'text-sky-800',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'iconBg' => 'bg-sky-100',
            'iconColor' => 'text-sky-600',
        ],
    ];
    $s = $styles[$type] ?? $styles['success'];
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @if($autodismiss)
     x-init="setTimeout(() => show = false, {{ $autodismissSeconds * 1000 }})"
     @endif
     {{ $attributes->merge(['class' => 'mb-4']) }}>
    <div class="rounded-xl border {{ $s['border'] }} {{ $s['bg'] }} shadow-sm overflow-hidden">
        <div class="flex items-start gap-4 p-4">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $s['iconBg'] }} {{ $s['iconColor'] }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}" />
                </svg>
            </span>
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-medium {{ $s['text'] }}">
                    {{ $message ?: $slot }}
                </p>
            </div>
            @if($dismissible)
                <button type="button"
                        @click="show = false"
                        class="shrink-0 rounded-lg p-1.5 {{ $s['text'] }} hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent"
                        aria-label="{{ __('Cerrar') }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>
