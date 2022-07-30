<?php

namespace App\Http\Livewire\Repositories\Metadata\Optional;

use App\Models\Metadata;
use App\Models\MetadataValue;
use App\Models\Repository;
use Livewire\Component;

class Index extends Component
{
    public $page;
    public int $totalPages;
    public $allMetadata;
    public $metadataValues;
    public $repository;
    public $valuePairs;
    public $activeSection = "optional";

    public function mount(Repository $repository, ?int $page = null)
    {
        $this->repository = $repository;
        $this->page = $page;

        if ($page) {
            $this->allMetadata = Metadata::optional()->orderBy('position')->page($page)->get();
        } else {
            $this->allMetadata = Metadata::optional()->orderBy('position')->get();
        }

        $this->totalPages = Metadata::optional()->count() / Metadata::RECORDS_PER_PAGE;

        $this->valuePairs = value_pairs();

        $this->metadataValues = MetadataValue::select('metadata_id', 'value')
            ->whereRepository($repository)
            ->get();
    }

    public function render()
    {
        return view('livewire.repositories.show');
    }
}
