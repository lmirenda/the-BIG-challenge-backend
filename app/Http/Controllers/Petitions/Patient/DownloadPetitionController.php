<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Requests\DownloadPetitionRequest;
use App\Models\Petition;
use Illuminate\Support\Facades\Storage;

class DownloadPetitionController
{
    /**
     * Handle the incoming request.
     *
     * @param Petition $petition
     * @param DownloadPetitionRequest $request
     * @return string
     */
    public function __invoke(Petition $petition, DownloadPetitionRequest $request): string
    {
        if (config('filesystems.default')==='s3') {
            return response()->json([Storage::temporaryUrl(
                $petition->file,
                now()->addMinutes(5)
            ),
        ]);
        }

        return response()->json([Storage::url($petition->file)]);
    }
}
