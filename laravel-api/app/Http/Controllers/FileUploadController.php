<?php

namespace App\Http\Controllers;

use App\Jobs\FileUploadJob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request){

        $uploadId = $request->uploadId;
        $index = $request->index;

        $path = "temp/{$uploadId}";

        logger($request->all());        // normal inputs
        logger($request->files->all()); // uploaded files

        if(!$request->hasFile('chunk')){
            return response()->json(['error' => 'Upload chunk missing'], 400);
        }

        Storage::disk('public')->put("{$path}/{$index}", file_get_contents($request->chunk));

        if((int) $index + 1 == (int) $request->total){
            FileUploadJob::dispatch($uploadId, $request->fileName,$request->total);
        }

        return response()->json(['status' => 'chunk uploaded']);
    }
}
