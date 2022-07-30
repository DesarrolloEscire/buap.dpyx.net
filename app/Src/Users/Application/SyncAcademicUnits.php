<?php

namespace App\Src\Users\Application;

use App\Models\Metadata;
use App\Models\MetadataValue;
use App\Models\User;

class SyncAcademicUnits
{
    public function handle(User $user, $academicUnits)
    {


        $user->academicUnits()->sync(
            $academicUnits->pluck('id')
        );

        $user->repositories->each(function ($repository) use ($academicUnits) {

            $metadata = Metadata::where('name', Metadata::DC_CONTRIBUTOR_DEPARTMENT)->first();

            $metadata->metadataValues()->whereRepository($repository)->delete();

            if ($academicUnits->isEmpty()) {
                return;
            }

            $academicUnits->each(function ($academicUnit) use ($metadata, $repository) {
                $metadataValue = $metadata->metadataValues()->create([
                    'value' => $academicUnit->name
                ]);

                $metadataValue->repositories()->sync($repository);
            });
        });
    }
}
