<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Subnavigation extends Component
{
    public $routes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subnavigation');
    }
}
