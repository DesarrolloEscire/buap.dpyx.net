<?php

namespace App\Http\Livewire\Repositories;

use App\Models\Repository;
use Livewire\Component;

class DigitalResources extends Component
{
    public $repository;

    public function mount(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.repositories.digital-resources');
    }
}
