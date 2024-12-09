<?php

namespace App\Services\User;

use App\Interfaces\Auth\VerificationInServicesInterface;
use App\Models\User;
use App\Models\Verification;
use App\Traits\HasVerification;
use Random\RandomException;

class UserUpdateService implements VerificationInServicesInterface
{
    use HasVerification;

    public function __construct(private $data, private readonly User $user)
    {
        $this->data['type'] = 'user';
    }

    /**
     * @throws RandomException
     */
    public function sendCode(): void
    {
        $this->user->update([
            'name' => $this->data['name'] ?? $this->user['name'],
            'latitude' => $this->data['latitude'] ?? $this->user['latitude'],
            'longitude' => $this->data['longitude'] ?? $this->user['longitude'],
        ]);
        $this->deleteInvalidCodeIfExists();
        $this->data['name']=$this->user['name'];
        $this->sendVerificationCode();
    }

    public function deleteInvalidCodeIfExists(): void
    {
        Verification::query()->where('phone_number', $this->data['phone_number'])?->delete();
    }

    /**
     * @throws \Exception
     */
    public function updateIfCorrect(): void
    {
        $this->verification()?->delete();
        $this->user->update([
            'phone_number' => $this->data['phone_number']
        ]);
    }
}
