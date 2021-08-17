<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function storeFileFromRequest($request, $fileVar, $path){
        $file = $request->file($fileVar);
        $fPath = $file->store($path);
        $newFile = Storage::url($fPath);
        return $newFile;
    }
}
