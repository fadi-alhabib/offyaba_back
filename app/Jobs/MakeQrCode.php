<?php

namespace App\Jobs;

use App\Models\QrCode;
use App\Services\EncryptionServices;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MakeQrCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly int $duplication, private readonly int $numberOfUsage, private readonly int $period)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $arr = [];
        for ($i = 0; $i < $this->duplication; $i++) {
            $qr = QrCode::query()->create([
                'number_of_usage' => $this->numberOfUsage,
                'period' => $this->period,
            ]);
            $arr[] = EncryptionServices::encrypt(array(
                'id' => $qr['id'],
                'token' => config('app.qr_code.activation')
            ));
        }
        $pdf = Pdf::loadView('qrList', compact('arr'));
        Storage::put('QrCodes/' . $this->period . ' Months/' . $this->numberOfUsage . ' Usages/' . now()->format('d-m-Y i') . ' Codes.pdf', $pdf->output());
    }
}
