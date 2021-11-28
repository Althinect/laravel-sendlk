<?php

namespace Althinect\LaravelSendlk;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class LaravelSendlk
{

    private $statusCode;
    

    public function __construct()
    {
        $this->statusCode = 0;
        
    }

    public function send($phoneNumbers, $message)
    {
        if (!is_array($phoneNumbers)) {
            return $this->serializeResponse(true, 'phone numbers variable must be an array!');
        }

        $phoneNumbersValid = $this->validatePhoneNumbers($phoneNumbers);

        if (!$phoneNumbersValid) {
            return $phoneNumbersValid;
        }

        if (count($phoneNumbers) == 1) {
            $response = Http::withToken(config('laravel-sendlk.api_token'))->post('https://sms.send.lk/api/v3/sms/send', [
                'recipient' => $phoneNumbers[0],
                'sender_id' => config('laravel-sendlk.sender_id'),
                'message' => $message,
            ]);
        } else {
            for ($x=0; $x<count($phoneNumbers); $x++) 
            {
                $response = Http::withToken(config('laravel-sendlk.api_token'))->post('https://sms.send.lk/api/v3/sms/send', [
                    'recipient' => $phoneNumbers[$x],
                    'sender_id' => config('laravel-sendlk.sender_id'),
                    'message' => $message,
                ]);
            }
        }

        return $this->serializeResponse(false, 'Message(s) sent successfully');
    }

    private function validatePhoneNumbers($numbers)
    {
        foreach ($numbers as $number)
        {
            if (strlen($number) < 10) {
                return $this->serializeResponse(true, "Phone number: $number is not valid!");
            }
        }

        return true;
    }

    private function serializeResponse(bool $error, string $message)
    {
        if ($error) {
            return json_encode(array("status" => "error", "message" => $message));
        }
        return json_encode(array("status" => "success", "message" => $message));
    }
}
