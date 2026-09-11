<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Messages\Channel\SMS\SMSText;

class VonageSmsService
{
    protected Client $client;

    public function __construct()
    {
        $basic = new Basic(
            config('services.vonage.api_key'),
            config('services.vonage.api_secret')
        );

        $this->client = new Client($basic);
    }

    public function send(string $to, string $message): void
    {
        $sms = new SMSText(
            $to,
            config('services.vonage.from'),
            $message
        );

        $this->client->messages()->send($sms);
    }
}