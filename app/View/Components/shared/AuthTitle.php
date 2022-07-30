<?php

namespace App\View\Components\Shared;

use Illuminate\View\Component;

class AuthTitle extends Component
{

    public $title;
    public $subtitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $subtitle="")
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.auth-title');
    }
}
