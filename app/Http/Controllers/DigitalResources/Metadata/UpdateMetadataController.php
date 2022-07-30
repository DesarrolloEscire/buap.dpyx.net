<?php

namespace App\Http\Controllers\DigitalResources\Metadata;

use App\Http\Controllers\Controller;
use App\Models\DigitalResource;
use App\Models\File;
use App\Models\Metadata;
use App\Models\Url;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateMetadataController extends Controller
{
    const METADATA_INPUT_NAME = "metadata";

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(DigitalResource $digitalResource, Request $request)
    {

        $metadataNames = $request->collect(self::METADATA_INPUT_NAME)->keys();
        $metadata = Metadata::whereIn('name', $metadataNames)->get();

        $metadataValues = $digitalResource
            ->metadataValues()
            ->whereIn('metadata_id', $metadata->pluck('id'))
            ->delete();

        foreach ($request->collect(self::METADATA_INPUT_NAME)->filter() as $metadataName => $metadataValues) {

            $metadata = Metadata::whereName($metadataName)->first();

            if (!$metadata) {
                continue;
            }

            foreach ($metadataValues as $metadataValue) {
                $digitalResource->metadataValues()->create([
                    'metadata_id' => $metadata->id,
                    'value' => $metadataValue
                ]);
            }
        }

        $digitalResource->urls()->delete();

        $urlValue = $request->input('url');

        if ($urlValue) {
            $url = Url::create([
                'value' => $urlValue
            ]);

            $digitalResource
                ->urls()
                ->sync([$url->id]);
        }

        $file = $request->file('file');

        if (!$file) {
            Alert::success("Información actualizada.");
            return redirect()->back();
        }

        $path = "app/digital-resources/$digitalResource->id";
        $fileName = $file->getClientOriginalName();
        $file->move(storage_path($path), $fileName);

        $digitalResource->files()->delete();

        $newFile = File::create([
            'path' => $path . "/" . $fileName
        ]);

        $digitalResource->files()->sync($newFile);

        Alert::success("Información actualizada.");
        return redirect()->back();
    }
}
