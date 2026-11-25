@props([
    'type' => 'success',
    'dismissible' => true,
])

@php
    $config = [
        'success' => [
            'class' => 'alert-success',
            'icon' => 'bi-check-circle-fill',
        ],
        'error' => [
            'class' => 'alert-danger',
            'icon' => 'bi-exclamation-circle-fill',
        ],
        'warning' => [
            'class' => 'alert-warning',
            'icon' => 'bi-exclamation-triangle-fill',
        ],
        'info' => [
            'class' => 'alert-info',
            'icon' => 'bi-info-circle-fill',
        ],
    ];

    $alert = $config[$type] ?? $config['info'];
@endphp

@if ($slot->isNotEmpty())
    <div
        class="alert {{ $alert['class'] }} d-flex align-items-start gap-2 rounded-3 border-0 mb-4"
        role="alert"
    >
        <i class="bi {{ $alert['icon'] }} mt-1"></i>

        <div class="flex-grow-1">
            {{ $slot }}
        </div>

        @if ($dismissible)
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Tutup"
            ></button>
        @endif
    </div>
@endif
