<?php

namespace App\Services\QrCode;

use App\Http\Resources\QR\EmployeeScanResource;
use App\Interfaces\QrCodeScanInterface;
use App\Models\QrCode;
use Illuminate\Support\Env;

class EmployeeQrScanService implements QrCodeScanInterface
{
    /**
     * @param array $array
     * @return array
     * @throws \Exception
     */
    public function check(array $array): array
    {
        $qr = QrCode::find($array['id']);

        if ($array['token'] != config('app.qr_code.usage') ||
            !$qr ||
            is_null($qr['user_id']) ||
            !$qr['is_valid']) {
            throw new \Exception('Invalid QR Code !!!');
        }

        if (now()->subMinutes(5)->lessThan($qr['updated_at'])) {
            throw new \Exception('Please wait for ' . 5 - (now()->minute - $qr['updated_at']->minute) . ' minutes');
        }

        $array = array(
            'number_of_usage' => $qr['number_of_usage'] - 1
        );
        $store = auth('employee-api')->user()->store;
        $store->update([
            'score' => $store['score'] + 1
        ]);
        $qr->update($array);
        return array(
            'data' => EmployeeScanResource::make($qr),
            'message' => "ok"
        );
    }
}
