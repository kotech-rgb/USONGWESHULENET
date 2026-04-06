<?php

namespace App\Services;

use GuzzleHttp\Client;
use InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use App\Models\Company;

class SmsService
{
    private Client $client;
    private array $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'Basic S290ZWNoOktvdGFzaUAwMDE=',
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * NEW: Schedule a Single SMS
     * Endpoint: /api/sms/v1/text/single
     */
    public function scheduleSMS(string $to, string $text, string $date, string $time): array
    {
        $userCompanyName = auth()->user()->company_from;
        $senderID ="SCHOOL";
        $to = $this->formatPhoneNumber($to);
        $payload = [
            'from' => $senderID,
            'to'   => $to,
            'text' => $text,
            'date' => $date, // Format: YYYY-MM-DD
            'time' => $time, // Format: HH:MM
        ];

        try {
            $response = $this->client->post('https://messaging-service.co.tz/api/sms/v1/text/single', [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $body = json_decode($response->getBody(), true);
            $messageId = $body['messageId'] ?? ($body['messages'][0]['messageId'] ?? null);

            return [
                'success'   => true,
                'messageId' => $messageId,
                'response'  => $body,
            ];
        } catch (RequestException $e) {
            return [
                'success'   => false,
                'messageId' => null,
                'response'  => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : $e->getMessage(),
            ];
        }
    }

    /**
     * Send Immediate SMS (Single Destination)
     */
    public function sendSMS(string $to, string $text, string $reference = null): array
    {
        $senderID = "SCHOOL";
        $to = $this->formatPhoneNumber($to);
        $payload = [
            'from'      => $senderID,
            'to'        => $to,
            'text'      => $text,
            'reference' => $reference,
        ];

        try {
            $response = $this->client->post('https://messaging-service.co.tz/api/sms/v1/text/single', [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $body = json_decode($response->getBody(), true);
            $messageId = $body['messageId'] ?? ($body['messages'][0]['messageId'] ?? null);

            return [
                'messageId' => $messageId,
                'response'  => $body,
            ];
        } catch (RequestException $e) {
            return [
                'messageId' => null,
                'response'  => $e->getMessage(),
            ];
        }
    }


    public function DefaultSender(string $to, string $text, string $reference = null): array
    {
        $senderID = "KOTECH";
        $to = $this->formatPhoneNumber($to);
        $payload = [
            'from'      => $senderID,
            'to'        => $to,
            'text'      => $text,
            'reference' => $reference,
        ];

        try {
            $response = $this->client->post('https://messaging-service.co.tz/api/sms/v1/text/single', [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $body = json_decode($response->getBody(), true);
            $messageId = $body['messageId'] ?? ($body['messages'][0]['messageId'] ?? null);

            return [
                'messageId' => $messageId,
                'response'  => $body,
            ];
        } catch (RequestException $e) {
            return [
                'messageId' => null,
                'response'  => $e->getMessage(),
            ];
        }
    }

    /**
     * Get SMS Balance
     */
    public function getSmsBalance(): array
    {
        try {
            $response = $this->client->get('https://messaging-service.co.tz/api/sms/v1/balance', [
                'headers' => $this->headers,
            ]);
            $body = json_decode($response->getBody(), true);
            return [
                'success' => true,
                'balance' => $body,
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'error'   => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : $e->getMessage(),
            ];
        }
    }

    /**
     * Get Delivery Reports
     */
    public function getDeliveryReportFromLogs(string $from, string $sentSince, string $sentUntil): array 
    {
        try {
            $response = $this->client->get('https://messaging-service.co.tz/api/sms/v1/logs', [
                'headers' => $this->headers,
                'query' => [
                    'from'      => $from,
                    'sentSince' => $sentSince,
                    'sentUntil' => $sentUntil,
                ],
            ]);
            $body = json_decode($response->getBody(), true);
            return ['success' => true, 'results' => $body['results'] ?? $body];
        } catch (RequestException $e) {
            return [
                'success' => false, 
                'error'   => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : $e->getMessage()
            ];
        }
    }

    /**
     * Format Tanzanian phone numbers
     */
    private function formatPhoneNumber(string $number): string
    {
        $number = preg_replace('/\D/', '', $number);

        if (str_starts_with($number, '0')) {
            return '255' . substr($number, 1);
        }
        if (str_starts_with($number, '255')) {
            return $number;
        }
        if (str_starts_with($number, '6') || str_starts_with($number, '7')) {
            return '255' . $number;
        }
        throw new InvalidArgumentException("Invalid phone number format: {$number}");
    }
}