<?php

namespace App\Http\Controllers\Auth;

use App\Services\UsersService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Error\ErrorResource;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $UsersService;

    public function __construct(UsersService $UsersService)
    {
        $this->UsersService = $UsersService;
    }

    public function store(RegisterRequest $request)
    {

        try {
            // Send Request Service Provider Side
            $isSave = $this->UsersService->save($request);

            // Getting Response are true or false
            $response = $isSave ? new UserResource($isSave) : new ErrorResource('User Not be Created');

            // Set http  status code
            $response_code = $isSave ? 200 : 500;

            // return response in json format
            return response()->json($response, $response_code);
        } catch (\Throwable $th) {
            // Sending an error
            return response()->json(new ErrorResource($th->getMessage()), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            // getting user using uuid
            $isUser = $this->UsersService->getUser($request);

            // Getting Response are true or false
            $response = $isUser ? new UserResource($isUser) : new ErrorResource('User not found');

            // Set http  status code
            $response_code = $isUser ? 200 : 404;

            // return response in json format
            return response()->json($response, $response_code);
        } catch (\Throwable $th) {
            // Sending an error
            return response()->json(new ErrorResource($th->getMessage()), 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'User successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token invalid']);
        }
    }
}
