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

    public function send($phoneNumber, $message)
    {
        $response = Http::withToken(config('laravel-sendlk.api_token'))->post('https://sms.send.lk/api/v3/sms/send', [
            'recipient' => $phoneNumber,
            'sender_id' => config('laravel-sendlk.sender_id'),
            'message' => $message,
        ]);

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
