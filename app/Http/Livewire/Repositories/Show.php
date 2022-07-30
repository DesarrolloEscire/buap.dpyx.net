<?php

declare(strict_types=1);

namespace App\Http\Livewire\Repositories;

use App\Models\Metadata;
use App\Models\MetadataValue;
use App\Models\Repository;
use Livewire\Component;

class Show extends Component
{
    public $exeLearningFile;
    public $webFile;
    public $scormFile;
    public $repository;
    public $allMetadata;
    public $valuePairs;
    public $metadataValues;
    public $activeSection = "required";

    public function mount(Repository $repository)
    {
        $this->exeLearningFile = $repository->files()->wherePivot('type', 'exelearning')->first();
        $this->webFile = $repository->files()->wherePivot('type', 'web')->first();
        $this->scormFile = $repository->files()->wherePivot('type', 'scorm')->first();

        $this->repository = $repository;

        $this->allMetadata = Metadata::required()->orderBy('position')->get();

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
