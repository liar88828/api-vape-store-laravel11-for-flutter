<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface UserRepositoryInterface
{
    function findEmail(string $email);

    function validRegister(Request $request);

    function validLogin(Request $request);

    function registerUser(Request $data);

    function logoutUser();

    function checkPassword(string $reqPassword, string $dbPassword);

    function checkEmail(string $email);
}
