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
