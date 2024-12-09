<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoggingInInterface;
use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\Employee;
use App\Models\User;
use App\Traits\HasVerification;
use Exception;

class ResendCodeEmployeeService implements VerificationInServicesInterface
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
            throw new Exception('You Do not have authority to login');
        }
        $this->data['name']=$employee['name'];
        return $this;
    }
}
