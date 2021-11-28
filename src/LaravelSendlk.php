<?php

namespace Althinect\LaravelSendlk;

use Althinect\LaravelSendlk\Models\MessageLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class LaravelSendlk
{

    public function send($phoneNumbers, $message)
    {
        if (!is_array($phoneNumbers)) {
            $response = $this->serializeResponse(true, 'phone numbers variable must be an array!');
            $this->logMessage(false, null, $response);
            return $response;
        }

        $phoneNumbersValid = $this->validatePhoneNumbers($phoneNumbers);

        if (!is_bool($phoneNumbersValid)) {
            $this->logMessage(false, null, $phoneNumbersValid);
            return $phoneNumbersValid;
        }

        for ($x=0; $x<count($phoneNumbers); $x++) 
        {
            $response = Http::withToken(config('laravel-sendlk.api_token'))->post('https://sms.send.lk/api/v3/sms/send', [
                'recipient' => $phoneNumbers[$x],
                'sender_id' => config('laravel-sendlk.sender_id'),
                'message' => $message,
            ]);

            $responseError = $this->inspectResponse($response);

            if (!is_bool($responseError)) {
                $this->logMessage(false, $phoneNumbers[$x], $response->body());
                return $responseError;
            } else {
                $this->logMessage(true, $phoneNumbers[$x], $response->body());
            }
        }
        
        return $this->serializeResponse(false, 'Message(s) sent successfully');
    }

    private function inspectResponse(Response $response) 
    {
        if ($response->failed() || $response->serverError() || $response->clientError()) {
            return $this->serializeResponse(true, $response->body());
        }

        return true;
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

    private function logMessage($success, $phoneNumber, $responseBody)
    {
        $log = new MessageLog;

        $log->success = $success;
        $log->phone_number = $phoneNumber;
        $log->api_response = $responseBody;

        $log->save();
    }
}
