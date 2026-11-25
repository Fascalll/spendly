<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PageHeader extends Component
{
    public function __construct(
        public string $title,
        public ?string $subtitle = null,
    ) {
    }

    public function render(): View
    {
        return view('components.page-header');
    }
}
