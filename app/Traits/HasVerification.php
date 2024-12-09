<?php

namespace App\Traits;

use App\Jobs\SendWhatsAppCode;
use App\Jobs\VerifyPhone;
use App\Models\Verification;
use Exception;
use Random\RandomException;
use Twilio\Rest\Client;

trait HasVerification
{
    /**
     * @throws RandomException
     */
    public function sendVerificationCode(): void
    {

        Verification::query()->where('phone_number', $this->data['phone_number'])->where('type', $this->data['type'])?->delete();
        $code = random_int(100000, 999999);
        Verification::query()->create([
            'phone_number' => $this->data['phone_number'],
            'code' => $code,
            'type' => $this->data['type']
        ]);
        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.auth_token');
        $twilioServiceId = config('services.twilio.service_id');
        $twilio = new Client($twilioSid, $twilioToken);
        try {
            $verification = $twilio->verify->v2->services($twilioServiceId)->verifications->create(
                $this->data['phone_number'],
                "sms",
                ["customCode" => $code],
            );
        } catch (\Twilio\Exceptions\RestException $ex) {
            logger("Twilio error: " . $ex->getMessage());
            logger("Twilio status code: " . $ex->getStatusCode());
            logger("Twilio details: " . json_encode($ex->getDetails()));
            throw $ex;
        }

        Verification::where('phone_number', $this->data['phone_number'])->update(['sid' => $verification->sid]);
        // dispatch(new SendWhatsAppCode($code, $this->data['name'], $this->data['phone_number']));
    }

    /**
     * @throws Exception
     */
    public function verification(): Verification
    {
        $verification = Verification::query()
            ->where('phone_number', $this->data['phone_number'])
            ->where('code', $this->data['code'])
            ->where('type', $this->data['type'])
            ->first();
        if (!$verification || ($verification['created_at']->addminutes(10) < now())) {
            throw new Exception('The provided code is invalid');
        }
        $sid = $verification->sid;

        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.auth_token');
        $twilioServiceId = config('services.twilio.service_id');

        $twilio = new Client($twilioSid, $twilioToken);
        $sent = $twilio->verify->v2
            ->services($twilioServiceId)
            ->verifications($sid)
            ->update(
                "approved"
            );
        // dispatch(new VerifyPhone($verification->phone_number));
        return $verification;
    }
}
