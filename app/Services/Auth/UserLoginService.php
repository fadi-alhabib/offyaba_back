<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoggingInInterface;
use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\User;
use App\Models\Verification;
use App\Traits\HasVerification;
use Exception;


class UserLoginService implements LoggingInInterface, VerificationInServicesInterface
{

    use HasVerification;

    function __construct(private $data)
    {
    }

    /**
     *
     * @return $this
     * @throws Exception
     */
    public function get(): static
    {
        $user = User::firstWhere('phone_number',$this->data['phone_number']);
        if(!$user){
            throw new Exception("لا يوجد لديك حساب, الرجاء انشاء حساب أولاً");
        }
        $this->data['name']=$user['name'];
        return $this;
    }


    public function allowLogin(): User
    {
        $user = User::firstWhere('phone_number',$this->data['phone_number']);
        $user['token'] = $user->createToken('OffYaba##4', ['user'])->accessToken;
        return $user;
    }
}
