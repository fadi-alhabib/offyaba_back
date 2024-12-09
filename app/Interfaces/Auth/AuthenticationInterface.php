<?php

namespace App\Interfaces\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

interface AuthenticationInterface
{
    public function login(LoginRequest $request);
    public function register(RegisterRequest $request);
    public function logout();

}
