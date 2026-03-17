@if (session('status'))
    <x-alert type="success" :message="session('status')" :dismissible="true" :autodismiss="true" :autodismissSeconds="6" />
@endif
@if (session('error'))
    <x-alert type="error" :message="session('error')" :dismissible="true" />
@endif
@if (session('warning'))
    <x-alert type="warning" :message="session('warning')" :dismissible="true" />
@endif
@if (session('info'))
    <x-alert type="info" :message="session('info')" :dismissible="true" />
@endif
