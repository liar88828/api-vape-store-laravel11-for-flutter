<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(Request $request)
    {
        try {

            // Validate the incoming request
            $valid = $this->userRepository->validRegister($request);

            // Create the user
            $user = $this->userRepository->registerUser($request);
//            $token = $user->createToken('auth_token')->plainTextToken;
//
            return response()->json([
                'message' => 'User registered successfully!',
                'user' => $user,
//                'token' => $token,
                'token_type' => 'Bearer'
            ], 201);

        } catch (\Exception $exception) {
//            print_r($exception->getMessage());
            return response()->json([
                'message' => $exception->getMessage(),
//                'message' => 'error bos',
            ]);

        }
    }


    public function login(Request $request)
    {
        try {
            $this->userRepository->validLogin($request);
            $user = $this->userRepository->checkEmail($request->email);
            $this->userRepository->checkPassword($request->password, $user['password']);

            $user['password'] = '';
            // Generate a token for the user (assuming you're using Laravel Sanctum or Passport for API authentication)
//            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'User logged in successfully!',
                'user' => $user,
//                'token' => $token,
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();
//        Auth::user()->getRememberTokenName()->delete();
        return response()->json([
            'message' => 'User logged out successfully!',
        ]);
    }
}
