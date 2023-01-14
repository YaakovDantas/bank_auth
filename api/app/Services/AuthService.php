<?php

namespace App\Services;

use App\Entities\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function validateCredentials($credentials)
    {
        if (! Auth::attempt($credentials)) {
            throw new \Exception('login unauthorized', 401);
        }

        return true;
    }

    public function createToken(User $user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }

    public function userFromAccessToken($access_token)
    {
        if(! $token = PersonalAccessToken::findToken($access_token)) {
            throw new \Exception("user not found from token {$access_token}", 400);
        }

        return $token->tokenable;
    }

    public function revokeAllTokens(User $user)
    {
        if (! $user->tokens()->delete()) {
            throw new \Exception('fail revoke all tokens', 400);
        }

        return true;
    }

    public function revokeToken(User $user)
    {
        if (! $user->tokens()->where('tokenable_id', $user->id)->delete()) {
            throw new \Exception('fail revoke token', 400);
        }

        return true;
    }
}