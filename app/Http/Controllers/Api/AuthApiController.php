<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Api\AuthApiRepository;
use App\Http\Requests\Api\GetUserEmailRequest;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Services\Keys;

class AuthApiController extends Controller
{
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



}
