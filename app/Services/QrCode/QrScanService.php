<?php

namespace App\Services\QrCode;

use App\Http\Resources\QR\EmployeeScanResource;
use App\Models\QrCode;
use App\Services\EncryptionServices;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Crypt;

class QrScanService
{
    private $array;

    public function __construct(private $code)
    {
        //
    }

    /**
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function decrypt(): static
    {
        $this->array = EncryptionServices::decrypt($this->code);
        return $this;
    }

    /**
     * @return array|string[]
     * @throws \Exception
     */
    public function check(): array
    {
        if (in_array('auth.any:user', request()->route()->gatherMiddleware())) {
            return (new UserQrScanService)->check($this->array);
        } else {
            return (new EmployeeQrScanService)->check($this->array);
        }
    }
}
