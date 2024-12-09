<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrCode\CreateQrCodeRequest;
use App\Http\Requests\QrCode\ScanRequest;
use App\Http\Resources\QR\UserQrCodeInfo;
use App\Jobs\MakeQrCode;
use App\Models\QrCode;
use App\Services\EncryptionServices;
use App\Services\QrCode\QrScanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    public function index()
    {
        $qr = auth('user-api')->user()->qrCodes()->latest('updated_at')->get();
        if (!$qr->count()) {
            return $this->failed('You don\'t have any QR codes');
        }
        $qr = $qr->sortByDesc('is_valid');
        return $this->success(UserQrCodeInfo::collection($qr));
    }

    public function create(CreateQrCodeRequest $request)
    {
        $data = $request->validated();
        dispatch(new MakeQrCode($data['duplication'], $data['number_of_usage'], $data['period']));
        return $this->success(null, 'Qr Codes added successfully');
    }

    public function scan(ScanRequest $request)
    {
        $request->validated();
        $qrCode = new QrScanService($request['code']);
        try {
            $info = $qrCode->decrypt()
                ->check();
            return $this->success($info['data'], $info['message']);
        } catch (Exception $ex) {
            return $this->failed($ex->getMessage());
        }
    }
}
