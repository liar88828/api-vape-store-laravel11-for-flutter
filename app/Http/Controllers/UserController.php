<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

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

            $this->userRepository->validRegister($request);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $token = $user->createToken('myAppToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully!',
                'data' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ],);

        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("fail register : {$exception->getMessage()}");
        }
    }


    public function login(Request $request)
    {
        try {
            $this->userRepository->validLogin($request);
            $user = User::query()->where('email', $request->email)->first();
            $this->userRepository->checkPassword($request->password, $user['password']);
            $token = $user->createToken('myAppToken')->plainTextToken;
            return response()->json([
                'data' => $user,
                'token' => $token,
                'message' => 'User logged in successfully!',
            ]);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("fail login : {$exception->getMessage()}");

        }
    }

    public function getUser(Request $request)
    {
        try {
//            print_r($request->bearerToken());

            if (auth('sanctum')->check()) {
                return ApiResponseClass::sendResponse($request->user(), 'Success get User Data');
            }
            throw  new \Exception('Token is not valid');
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Success get User Data : {$exception->getMessage()}");
        }

    }

    public function logout(Request $request)
    {
        try {
//            $token = PersonalAccessToken::findToken($hashedTooken);
            if (auth('sanctum')->check()) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'User logged out successfully!',]);
            }
            throw  new \Exception('Token is not valid');
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("fail logout : {$exception->getMessage()}");
        }
    }
}
