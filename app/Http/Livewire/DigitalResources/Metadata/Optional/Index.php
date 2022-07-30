<?php

namespace App\Http\Livewire\DigitalResources\Metadata\Optional;

use App\Models\DigitalResource;
use App\Models\Metadata;
use App\Models\MetadataValue;
use Livewire\Component;

class Index extends Component
{
    public $digitalResource;
    public $allMetadata;
    public $valuePairs;
    public $activeSection;

    public function mount(DigitalResource $digitalResource)
    {
        $this->activeSection = "optional";

        $this->digitalResource = $digitalResource;

        $this->valuePairs = value_pairs();

        $this->allMetadata = Metadata::optional()
            ->orderBy('position')
            ->get();

        $this->metadataValues = MetadataValue::select('metadata_id', 'value')
            ->whereDigitalResource($digitalResource)
            ->get();
    }

    public function render()
    {
        return view('livewire.digital-resources.metadata.index');
    }
}
