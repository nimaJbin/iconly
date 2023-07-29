<?php

namespace App\Http\Repositories\Api;

use App\Enums\UserSecurityStatus;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthApiRepository
{
    public static function checkUserExist($email)
    {
        $user = User::query()->where('email', strtolower(trim($email)))->first();
        if (!$user){
            return null;
        }
        return new UserResource($user);

    }

    public static function createUserWithEmail($email)
    {
        $user = User::query()->create([
            'email' => strtolower(trim($email))
        ]);

        return new UserResource($user);
    }





}
