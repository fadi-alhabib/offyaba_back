<?php

namespace App\Services\Auth;


use App\Interfaces\Auth\LoggingInInterface;
use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\Employee;
use App\Traits\HasVerification;
use Exception;

class EmployeeRegisterService implements LoggingInInterface,VerificationInServicesInterface
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
            throw new Exception('You Do not have authority to sign up');
        }
        if(!is_null($employee['name'])){
            throw new Exception('You have an account already please login instead.');
        }
        return $this;
    }

    public function allowLogin():Employee
    {
        $employee = Employee::query()->firstWhere('phone_number', $this->data['phone_number']);
        $employee->update([
            'name'=>$this->data['name']
        ]);
        $employee['token'] = $employee->createToken('OffYaba##4', ['employee'])->accessToken;
        return $employee;
    }

}
