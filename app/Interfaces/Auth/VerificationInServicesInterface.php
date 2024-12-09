<?php

namespace App\Interfaces\Auth;

interface VerificationInServicesInterface
{
    public function sendVerificationCode();

    public function verification();
}
