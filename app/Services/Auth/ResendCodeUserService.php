<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\User;
use App\Traits\HasVerification;

class ResendCodeUserService implements VerificationInServicesInterface
{
    use HasVerification;

    function __construct(private $data)
    {
    }


    public function get(): static
    {
        $user= User::firstWhere('phone_number', $this->data['phone_number']);
        if($user){
            $this->data['name']=$user['name'];
        }
        return $this;
    }
}
