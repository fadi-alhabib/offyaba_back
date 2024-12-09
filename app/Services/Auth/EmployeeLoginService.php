<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoggingInInterface;
use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\Employee;
use App\Models\Verification;
use App\Traits\HasVerification;
use Exception;

class EmployeeLoginService implements LoggingInInterface,VerificationInServicesInterface
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
        $employee = Employee::query()->where('phone_number',$this->data['phone_number'])->first();
        if (!$employee) {
            throw new Exception('أنت لست مخول للدخول');
        }
        if(is_null($employee['name'])){
            throw new Exception('Please sign up first');
        }
        $this->data['name']=$employee['name'];
        return $this;
    }

    public function allowLogin():Employee
    {
        $user = Employee::query()->firstWhere('phone_number', $this->data['phone_number']);
        $user['token'] = $user->createToken('OffYaba##4', ['employee'])->accessToken;
        return $user;
    }

}
