<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">{{ $title }}</h1>

        @if ($subtitle)
        <p class="page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($slot->isNotEmpty())
    <div class="page-header-actions">
        {{ $slot }}
    </div>
    @endif
</div>
