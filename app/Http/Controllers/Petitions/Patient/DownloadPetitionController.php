<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\Request;
use function response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadPetitionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Petition $petition
     * @param DownloadPetitionRequest $request
     * @return BinaryFileResponse
     */
    public function __invoke(Petition $petition, DownloadPetitionRequest $request): BinaryFileResponse
    {
        $name = $petition->file;
        $pathToFile = '../storage/app/public/petition_files/'.$name;

        return response()->download($pathToFile);
    }
}
