<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PageAccessButton extends Component
{
    public $href;

    public function __construct($href)
    {
        $this->href = $href;
    }

    public function render(): View
    {
        return view('admin.components.page-access-button', ['href' => $this->href]);
    }
}
