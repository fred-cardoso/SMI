<?php

namespace App\Tasks;


use Illuminate\Support\Facades\Storage;

class ClearDownloadsDirectory
{
    public function __invoke()
    {
        Storage::deleteDirectory('download');
    }
}