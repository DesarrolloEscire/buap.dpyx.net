<?php

namespace App\Http\Controllers\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\MetadataValue;
use App\Models\Repository;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Publish extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Repository $repository)
    {
        $repositoryMetadataRequired = MetadataValue::whereRepository($repository)
            ->whereMetadataRequired()
            ->get()
            ->pluck('metadata')
            ->flatten()
            ->unique();

        $metadataRequired = Metadata::required();

        if ($repositoryMetadataRequired->count() != $metadataRequired->count()) {
            Alert::error("No se pudo realizar esta acción", "aún existen metadatos obligatorios por completar");
            return redirect()->back();
        }

        $repository->publish();

        Alert::success("El REA ha sido publicado exitósamente");
        return redirect()->back();
    }
}
