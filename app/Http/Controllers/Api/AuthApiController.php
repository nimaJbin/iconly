<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Api\AuthApiRepository;
use App\Http\Requests\Api\GetUserEmailRequest;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Services\Keys;

class AuthApiController extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/get_user_email",
     *  tags={"Auth Api"},
     *  description="getting user email",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *           @OA\Property(
     *                  property="email",
     *                  description="Enter Email",
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
     *               "message": "Your account exists. To log in, please enter your password.",
     *               "data": {
     *                   "User Data",
     *              }
     *        }
     *      )
     *   )
     *)
     **/
    public function getUserEmail(GetUserEmailRequest $request)
    {
        $user = AuthApiRepository::checkUserExist($request->email);

        if (!$user){
            $user = AuthApiRepository::createUserWithEmail($request->email);

            return Response()->json([
                'result' => true,
                'message' => "Your account has been created. Please create a password for it",
                'data' => [
                    $user
                ]
            ], 201);
        }

        return Response()->json([
            'result' => true,
            'message' => "Your account exists. To log in, please enter your password.",
            'data' => [
                $user
            ]
        ], 200);
    }

    /**
     * @OA\Post(
     ** path="/api/user_login",
     *  tags={"Auth Api"},
     *  description="User Login",
     * @OA\RequestBody(
     *    required=true,
     * *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *           @OA\Property(
     *                  property="user_id",
     *                  description="Enter user ID",
     *                  type="integer",
     *           ),
     *           @OA\Property(
     *                  property="password",
     *                  description="Enter password",
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
     *               "message": "You are logged in.",
     *               "data": {
     *                   "User Data And User token",
     *              }
     *        }
     *      )
     *   )
     *)
     **/
    public function userLogin(UserLoginRequest $request)
    {
        $userLogin = AuthApiRepository::userLogin($request->user_id, $request->password);

        if (!$userLogin) {
            return Response()->json([
                'result' => false,
                'message' => "Account not found. Make sure the input information is correct.",
                'data' => []
            ], 404);
        }

        return Response()->json([
            'result' => true,
            'message' => "You are logged in.",
            'data' => [
                Keys::user_id => $userLogin['user_id'],
                Keys::user_token => $userLogin['user_token']
            ]
        ], 202);
    }
}
