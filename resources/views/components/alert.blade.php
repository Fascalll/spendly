@props(['type' => 'success'])

@php
    $classes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];

    $class = $classes[$type] ?? 'alert-info';
@endphp

@if ($slot->isNotEmpty())
    <div class="alert {{ $class }} alert-dismissible fade show" role="alert">
        {{ $slot }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif

