<?php

namespace App\Services;

use App\Models\Observation;
use Illuminate\Support\Facades\Storage;


class ObservationService
{
    public $observation;

    public function __invoke(Observation $observation)
    {
        $this->observation = $observation;
        return $this;
    }

    // TODO remove files in server
    public function removeFiles($filesToDelete)
    {
        if ($filesToDelete == null) {
            return $this;
        }

        $currentFilesArray = $this->observation->files_paths;
        $filesToDelete = $filesToDelete;

        foreach ($currentFilesArray as $index => $file) {
            if (in_array($file['file_name'], $filesToDelete)) {
                unset($currentFilesArray[$index]);
            }
        }

        $this->observation->files_paths = $currentFilesArray;
        $this->observation->save();

        return $this;
    }

    public function storeFiles($filesToStore)
    {
        // TODO store files with their original and time name instied of only time
        foreach ($filesToStore as $image) {
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $path = Storage::disk('public')->putFileAs(
                'observations',
                $image,
                $fileName
            );

            $currentFiles = $this->observation->files_paths;
            $newFile['file_name'] = $fileName;
            $newFile['url'] = getenv('APP_URL') . '/storage\/' . $path;
            $currentFiles[] = $newFile;
            $this->observation->files_paths = $currentFiles;
        }

        return $this;
    }
}
