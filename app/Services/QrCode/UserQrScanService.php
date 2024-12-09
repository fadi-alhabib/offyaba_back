<?php

namespace App\Services\QrCode;

use App\Interfaces\QrCodeScanInterface;
use App\Models\QrCode;
use Illuminate\Support\Env;

class UserQrScanService implements QrCodeScanInterface
{

    /**
     * @param array $array
     * @return array
     * @throws \Exception
     */
    public function check(array $array): array
    {
        $qr = QrCode::find($array['id']);

        if ($array['token'] != config('app.qr_code.activation') ||
            !$qr ||
            $qr['user_id']) {
            throw new \Exception('Invalid QR Code !!!');
        }

        $array = array(
            'user_id' => auth('user-api')->id(),
            'expiration_date' => now()->addMonths($qr['period'])->toDateString()
        );
        $qr->update($array);
        return array(
            'data' => null,
            'message' => "QR Code added successfully"
        );
    }
}
