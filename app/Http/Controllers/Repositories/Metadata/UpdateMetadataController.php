<?php

namespace App\Http\Controllers\Repositories\Metadata;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\File;
use App\Models\Metadata;
use App\Models\Repository;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateMetadataController extends Controller
{
    const METADATA_INPUT = "metadata";

    public function __invoke(Repository $repository, Request $request)
    {

        if ($request->file('web_file')) {
            if ($request->file("web_file")->getClientOriginalExtension() != 'zip') {
                Alert::error('El archivo web debe tener extensión .zip');
                return redirect()->back();
            }
        }

        if ($request->file('scorm_file')) {
            if ($request->file("scorm_file")->getClientOriginalExtension() != 'zip') {
                Alert::error('El archivo web debe tener extensión .zip');
                return redirect()->back();
            }
        }
        
        if ($request->file('exelearning_file')) {
            if ($request->file("exelearning_file")->getClientOriginalExtension() != 'elp') {
                Alert::error('El archivo web debe tener extensión .elp');
                return redirect()->back();
            }
        }

        $metadataNames = $request->collect(self::METADATA_INPUT)->keys();

        $metadata = Metadata::whereIn('name', $metadataNames)->get();

        $metadataValues = $repository
            ->metadataValues()
            ->whereIn('metadata_id', $metadata->pluck('id'))
            ->delete();

        foreach ($request->collect(self::METADATA_INPUT)->filter() as $metadataName => $metadataValues) {

            $metadata = Metadata::whereName($metadataName)->first();

            if (!$metadata) {
                continue;
            }

            foreach ($metadataValues as $metadataValue) {
                $repository->metadataValues()->create([
                    'metadata_id' => $metadata->id,
                    'value' => $metadataValue
                ]);
            }
        }

        $repository->concepts()->delete();

        $request->collect('concepts')->filter()->each(function ($conceptDescription) use ($repository) {

            $newConcept = Concept::create(['description' => $conceptDescription]);

            $repository
                ->concepts()
                ->syncWithoutDetaching($newConcept);
        });

        $exeLearningFile = $request->file('exelearning_file');

        if ($exeLearningFile) {
            $path = "app/repositories/$repository->id/exelearning";
            $fileName = $exeLearningFile->getClientOriginalName();
            $exeLearningFile->move(storage_path($path), $fileName);

            $repository->files()->wherePivot("type", "exelearning")->delete();

            $newFile = File::create([
                'path' => $path . "/" . $fileName
            ]);

            $repository->files()->save($newFile, ['type' => 'exelearning']);
        }

        $scormFile = $request->file('scorm_file');

        if ($scormFile) {
            $path = "app/repositories/$repository->id/scorm";
            $fileName = $scormFile->getClientOriginalName();
            $scormFile->move(storage_path($path), $fileName);

            $repository->files()->wherePivot("type", "scorm")->delete();

            $newFile = File::create([
                'path' => $path . "/" . $fileName
            ]);

            $repository->files()->save($newFile, ['type' => 'scorm']);
        }

        $webFile = $request->file('web_file');

        if ($webFile) {
            $path = "app/repositories/$repository->id/web";
            $fileName = $webFile->getClientOriginalName();
            $webFile->move(storage_path($path), $fileName);

            $repository->files()->wherePivot("type", "web")->delete();

            $newFile = File::create([
                'path' => $path . "/" . $fileName
            ]);

            $repository->files()->save($newFile, ['type' => 'web']);
        }

        Alert::success("Se ha actualizado la información del REA.");

        return redirect()->back();
    }
}
