<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    function findEmail(string $email):array
    {
        return User::query()->where('email', $email)->first()->toArray();
    }

    function validRegister(Request $request)
    {

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        return $request;
    }

    function validLogin(Request $request)
    {

        // Validate the login credentials
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        return $request;
    }


    function registerUser(Request $data)
    {
//         Create the user
        $user = User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        return $user;
    }

    function logoutUser()
    {
        // TODO: Implement logout() method.
    }


    function checkEmail(string $email)
    {
        $response = $this->findEmail($email);
        if (!$response) {
            throw new \Exception('Email is not registered');
        }
        return $response;
    }

    function checkPassword(string $reqPassword, string $dbPassword)
    {
        if (!Hash::check($reqPassword, $dbPassword)) {
            throw  new \Exception('Wrong password');
        }
        return true;
    }


}
