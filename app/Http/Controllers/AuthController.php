<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @param AuthService $service
     */
    public function __construct(protected AuthService $service)
    {
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $token = $this->service->login($request);
        return response()
            ->json([
                'success' => true,
                'message' => 'Login successfully',
                'token' => $token
            ]);
    }


    /**
     * @return UserResource
     * @throws \Exception
     */
    public function info()
    {
        $response = $this->service->info();
        return new UserResource($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function logout()
    {
        $this->service->logout();
        return response()
            ->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
    }
}
