<?php

namespace App\View\Components\Metadata;

use App\Models\Metadata;
use App\Models\Repository;
use Illuminate\View\Component;

class Input extends Component
{
    public $metadata;
    public $repository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Repository $repository, Metadata $metadata)
    {
        $this->repository = $repository;
        $this->metadata = $metadata;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metadata.input');
    }
}
