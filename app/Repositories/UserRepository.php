<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface
{

    function findEmail(string $email): array
    {
        return User::query()->where('email', $email)->first()->toArray();
    }

    function validRegister(Request $request): array
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
        return $validator->getData();
    }

    function validLogin(Request $request): array
    {

        // Validate the login credentials
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        return $validator->getData();
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
