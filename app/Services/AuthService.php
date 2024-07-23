<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AuthService
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $user = User::whereEmail($request->input('email'))
            ->first();

        if (empty($user)) {
            throw new \Exception('User not found');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            throw new \Exception('Credentials not matched');
        }

        return $user->createToken('token')->accessToken;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws \Exception
     */
    public function info()
    {
        if (!auth()->check()) {
            throw new \Exception('Unauthorized');
        }

        return auth()->user();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function logout()
    {
        if (!auth()->check()) {
            throw new \Exception('Unauthorized');
        }

        auth()
            ->user()
            ->token()
            ->revoke();
    }
}
