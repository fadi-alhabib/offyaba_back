<?php

namespace App\Jobs;

use App\Models\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendWhatsAppCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $code, private readonly string $name, private readonly string $phoneNumber)
    {
    }

    /**
     * Execute the job.
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function handle(): void
    {
        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.auth_token');
        $twilioServiceId = config('services.twilio.service_id');
        $twilio = new Client($twilioSid, $twilioToken);
        $verification = $twilio->verify->v2->services($twilioServiceId)->verifications->create(
            $this->phoneNumber,
            "sms",
            ["customCode" => $this->code],
        );
        Verification::where('phone_number', $this->phoneNumber)->update(['sid' => $verification->sid]);
    }
}
