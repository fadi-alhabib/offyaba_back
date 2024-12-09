<?php

namespace App\Interfaces\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyRequest;

interface VerificationInterface
{
    public function verify(VerifyRequest $request);

    public function resendCode(LoginRequest $request);

}
