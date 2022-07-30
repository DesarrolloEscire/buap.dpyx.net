<?php

namespace App\Http\Livewire\Metadata;

use App\Models\Metadata;
use Livewire\Component;

class Index extends Component
{
    public $requiredMetadata;
    public $optionalMetadata;

    public function mount()
    {
        $this->requiredMetadata = Metadata::required()->orderBy('position')->get();
        $this->optionalMetadata = Metadata::optional()->orderBy('position')->get();
    }

    public function render()
    {
        return view('livewire.metadata.index');
    }
}
