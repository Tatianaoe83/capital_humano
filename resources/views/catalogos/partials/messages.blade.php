@if (session('status'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 text-sm sm:text-base">
        {{ session('status') }}
    </div>
@endif
