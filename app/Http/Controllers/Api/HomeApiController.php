<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Api\HomeApiRepository;
use Illuminate\Http\Request;
use App\Http\Services\Keys;

class HomeApiController extends Controller
{

    /**
     * @OA\Get(
     ** path="/api/homepage",
     *  tags={"Home Api"},
     *     description="Showing list of icons with pagination",
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
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

    /**
     * @OA\Post(
     ** path="/api/export_icons",
     *  tags={"Home Api"},
     *  description="Export icons in zip file",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *           @OA\Property(
     *                  property="icons",
     *                  description="Enter icons id's in Array => example [1,3,5,7]",
     *                  type="string",
     *       )
     *     )
     *   )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *           example ={
     *               "result": true,
     *               "message": "The zip file is ready.",
     *               "data": {
     *                   "Zip file path",
     *              }
     *        }
     *      )
     *   )
     *)
     **/
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
