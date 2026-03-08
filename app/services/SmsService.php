<?php

namespace App\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class SmsService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

public function sendSMS($to, $text, $reference)
{
    $to = $this->formatPhoneNumber($to);
    $headers = [
        'Authorization' => 'Basic S290ZWNoOktvdGFzaUAwMDE=',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];
    $body = json_encode([
        'from'      => 'SCHOOL',
        'to'        => $to,
        'text'      => $text,
        'reference' => $reference,
    ]);

    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://messaging-service.co.tz/api/sms/v1/text/single', [
        'headers' => $headers,
        'body'    => $body
    ]);

    return json_decode($response->getBody(), true);
}

/**
 * Convert numbers starting with 07 to 2557, or keep 255 if already correct.
 */
private function formatPhoneNumber($number)
{
    $number = preg_replace('/\D/', '', $number); // Remove any non-digits

    if (substr($number, 0, 1) === '0') {
        // Starts with 0 → convert to 255XXXXXXXXX
        return '255' . substr($number, 1);
    }

    if (substr($number, 0, 3) === '255') {
        // Already in correct format
        return $number;
    }

    if (substr($number, 0, 1) === '6' || substr($number, 0, 1) === '7') {
        // Missing leading 0 → prepend 255
        return '255' . $number;
    }

    throw new \InvalidArgumentException("Invalid phone number format: {$number}");
}




}
