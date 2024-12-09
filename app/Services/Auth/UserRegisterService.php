<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoggingInInterface;
use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\User;
use App\Traits\HasVerification;
use Exception;

class UserRegisterService implements LoggingInInterface, VerificationInServicesInterface
{
    use HasVerification;

    function __construct(private $data)
    {
    }

    /**
     * @throws Exception
     */
    public function get(): static
    {
        $user = User::firstWhere('phone_number', $this->data['phone_number']);
        if ($user) {
            throw new Exception("لديك حساب بالفعل, الرجاء تسجيل الدخول");
        }
        return $this;
    }

    public function allowLogin(): User
    {
        $user = User::query()->create([
            'name' => $this->data['name'],
            'phone_number' => $this->data['phone_number'],
            'longitude' => $this->data['longitude'] ?? null,
            'latitude' => $this->data['latitude'] ?? null
        ]);
        $user['token'] = $user->createToken('OffYaba##4', ['user'])->accessToken;
        return $user;
    }

}
