<?php

namespace App\Jobs;

use App\Models\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class VerifyPhone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $phone_number)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sid = Verification::where("phone_number", $this->phone_number)->first()->sid;

        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.auth_token');
        $twilioServiceId = config('services.twilio.service_id');

        $twilio = new Client($twilioSid, $twilioToken);
        $verification = $twilio->verify->v2
            ->services($twilioServiceId)
            ->verifications($sid)
            ->update(
                "approved"
            );
    }
}
