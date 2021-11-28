<?php

namespace Althinect\LaravelSendlk;

use Illuminate\Support\Facades\Http;

class LaravelSendlk
{

    private $statusCode;
    

    public function __construct()
    {
        $this->statusCode = 0;
        
    }

    public function send($phoneNumbers, $message)
    {
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

        $this->statusCode = $response->status();
    }

    public function messageStatus() 
    {
        if ($this->statusCode == 200) {
            return true;
        } 

        return false;
    }
}
