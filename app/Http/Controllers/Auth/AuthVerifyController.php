<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Interfaces\Auth\AuthenticationInterface;
use App\Interfaces\Auth\VerificationInterface;
use Exception;

class AuthVerifyController extends Controller implements AuthenticationInterface, VerificationInterface
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $className = "App\Services\Auth\\" . ucfirst(request('type')) . 'RegisterService';
        $data['type'] = request('type');
        $user = new $className($data);

        try {
            // $this->checkIraqPhoneNumber($request['phone_number']);
            $user->get()
                ->sendVerificationCode();
        } catch (Exception $ex) {
            dd($ex);
            return $this->failed($ex->getMessage());
        }
        return $this->success(null);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $className = "App\Services\Auth\\" . ucfirst(request('type')) . 'LoginService';
        $data['type'] = request('type');
        $user = new $className($data);

        try {
            // $this->checkIraqPhoneNumber($request['phone_number']);
            $user->get()
                ->sendVerificationCode();
        } catch (Exception $ex) {
            return $this->failed($ex->getMessage());
        }
        return $this->success(null);
    }


    public function verify(VerifyRequest $request)
    {
        $data = $request->validated();
        $className = "App\Services\Auth\\" . ucfirst(request('type')) . ucfirst(request('method')) . 'Service';
        $data['type'] = request('type');
        $user = new $className($data);

        try {
            // $this->checkIraqPhoneNumber($request['phone_number']);
            $user->verification()
                ->delete();

            $resourceName = 'App\Http\Resources\Auth\\' . ucfirst(request('type')) . 'VerifyResource';
            return $this->success($resourceName::make($user->allowLogin()), 'logged in successfully');
        } catch (Exception $ex) {
            return $this->failed($ex->getMessage());
        }
    }

    public function resendCode(LoginRequest $request)
    {
        $data = $request->validated();
        $className = "App\Services\Auth\\" . 'ResendCode' . ucfirst(request('type')) . 'Service';
        $data['type'] = request('type');
        $user = new $className($data);

        try {
            // $this->checkIraqPhoneNumber($request['phone_number']);
            $user->get()
                ->sendVerificationCode();
        } catch (Exception $ex) {
            return $this->failed($ex->getMessage());
        }
        return $this->success(null);
    }

    public function logout()
    {
        $guardName = request('type') . '-api';
        auth($guardName)->user()?->token()->delete();
        return $this->success(null, 'logged out successfully');
    }

    /**
     * @throws Exception
     */
    private function checkIraqPhoneNumber($phone)
    {
        if (!phone($phone)->isOfCountry('IQ'))
            throw new Exception('هذه الدولة غير متاحة حالياً, يرجى استخدام دولة العراق');
    }
}
