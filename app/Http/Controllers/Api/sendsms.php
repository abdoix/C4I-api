<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Http\Client\ClientExceptionInterface;

class sendsms extends Controller
{
    public function sendmessage()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("482002a4", "7qwnfbdtRkAeIvpu");
        $client = new \Vonage\Client($basic);
        $response=null;
        try {
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS("212688683466", "mobadarati", 'hello user you are the winner for this month id_secret: 82420384JLDSDSO')
            );
            return "done";
        } catch (ClientExceptionInterface $e) {
            return "test";
        }

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
