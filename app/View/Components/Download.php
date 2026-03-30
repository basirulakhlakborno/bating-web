<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Download extends Component
{
    public string $message;

    public string $buttonLabel;

    public string $iconSrc;

    public string $href;

    public function __construct(
        ?string $message = null,
        ?string $buttonLabel = null,
        ?string $iconSrc = null,
        ?string $href = null,
    ) {
        $this->message = $message ?? (string) config('babu88.download.message');
        $this->buttonLabel = $buttonLabel ?? (string) config('babu88.download.button_label');
        $this->iconSrc = $iconSrc ?? (string) config('babu88.download.icon');
        $this->href = $href ?? (string) config('babu88.download.href');
    }

    public function render(): View|Closure|string
    {
        return view('components.download');
    }
}
