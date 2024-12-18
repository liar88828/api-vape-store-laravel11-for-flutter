<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            Log::info('User Register');
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

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("fail register : {$exception->getMessage()}");
        }
    }


    public function login(Request $request)
    {
        try {
            Log::info("User Login");
            $this->userRepository->validLogin($request);
            $user = User::query()->where('email', $request->email)->first();
            if (!$user) {
                throw new Exception('User is not found');
            }
            $this->userRepository->checkPassword($request->password, $user['password']);
            $token = $user->createToken('myAppToken')->plainTextToken;
            return response()->json([
                'data' => $user,
                'token' => $token,
                'message' => 'User logged in successfully!',
            ]);
        } catch (Exception $exception) {
//            print_r($exception->getMessage());
            return ApiResponseClass::sendFail("Fail login : {$exception->getMessage()}");

        }
    }

    public function getUser(Request $request)
    {
        try {
//            print_r($request->bearerToken());

            if (auth('sanctum')->check()) {
                return ApiResponseClass::sendResponse($request->user(), 'Success get User Data');
            }
            throw  new Exception('Token is not valid');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Success get User Data : {$exception->getMessage()}");
        }

    }

    public function show($id)
    {

        try {
            $data = $this->userRepository->findId($id);
            return ApiResponseClass::sendResponse(new UserResource($data), "Bank Detail Successful $id", 201);

        } catch (Exception $exception) {
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
            throw  new Exception('Token is not valid');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("fail logout : {$exception->getMessage()}");
        }
    }
}
