<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Api\HomeApiRepository;
use Illuminate\Http\Request;
use App\Http\Services\Keys;

class HomeApiController extends Controller
{

    public function homepage()
    {
        return response()->json([
            'result' => true,
            'message' => 'List of icons',
            'data' => [
                Keys::icons => HomeApiRepository::iconList()
            ]
        ], 200);
    }


    public function exportIcons(Request $request)
    {
        return response()->json([
            'result' => true,
            'message' => 'The zip file is ready.',
            'data' => [
                Keys::zip_file => HomeApiRepository::createExcel(json_decode($request->icons), auth()->user())
            ]
        ], 200);
    }
}
