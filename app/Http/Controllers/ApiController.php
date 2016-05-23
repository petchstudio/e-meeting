<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Http\Requests;

class ApiController extends Controller
{
    public function storage($path)
    {
    	$storage = Storage::disk('public');
	    if(!$storage->exists($path)) abort(404);

	    $file = $storage->get($path);
	    $type = $storage->mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
    }
}
