@props([
    'icon' => 'bi-inbox',
    'title' => 'Belum ada data',
    'message' => null,
])

<div class="empty-state text-center py-5 px-3">
    <div class="empty-state-icon">
        <i class="bi {{ $icon }}"></i>
    </div>

    <h5 class="empty-state-title">
        {{ $title }}
    </h5>

    @if ($message)
        <p class="empty-state-message">
            {{ $message }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="empty-state-action mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
