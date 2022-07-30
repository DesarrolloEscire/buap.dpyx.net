<?php

namespace App\View\Components\Repositories;

use App\Models\Repository;
use Illuminate\View\Component;

class Submenu extends Component
{
    public $repository;
    public $activeSection;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Repository $repository, string $activeSection)
    {
        $this->repository = $repository;
        $this->activeSection = $activeSection;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.repositories.submenu');
    }
}
