<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;

class ClickPesaService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.clickpesa.base_url');
    }

    /* ======================================================
     | TOKEN MANAGEMENT (SESSION)
     |====================================================== */
    protected function getToken(): string
    {
        if (Session::has('clickpesa_token')) {
            return Session::get('clickpesa_token');
        }

        $response = Http::withHeaders([
            'api-key'   => config('services.clickpesa.api_key'),
            'client-id' => config('services.clickpesa.client_id'),
        ])->post($this->baseUrl . '/third-parties/generate-token');

        if (!$response->successful()) {
            Log::error('ClickPesa Token Generation Failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new Exception('ClickPesa token generation failed');
        }

        $data = $response->json();

        if (!isset($data['token'])) {
            throw new Exception('ClickPesa token missing in response');
        }

        $token = str_replace('Bearer ', '', $data['token']);
        Session::put('clickpesa_token', $token);
        return $token;
    }

    protected function clearToken(): void
    {
        Session::forget('clickpesa_token');
    }

    /* ======================================================
     | CORE REQUEST HANDLER
     |====================================================== */
    protected function request(string $method, string $endpoint, array $payload = []): array
    {
        $token = $this->getToken();
        $http = Http::withToken($token)
            ->acceptJson()
            ->asJson();
        $method = strtolower($method);

        $response = $method === 'get'
            ? $http->get($this->baseUrl . $endpoint, $payload)
            : $http->{$method}($this->baseUrl . $endpoint, $payload);

        // Retry once if token expired
        if ($response->status() === 401) {
            $this->clearToken();
            $token = $this->getToken();
            $http = Http::withToken($token)->acceptJson()->asJson();
            $response = $method === 'get'
                ? $http->get($this->baseUrl . $endpoint, $payload)
                : $http->{$method}($this->baseUrl . $endpoint, $payload);
        }

        if (!$response->successful()) {
            Log::error('ClickPesa API Error', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);
            throw new Exception($response->body());
        }
        return $response->json();
    }

    /* ======================================================
     | PAYMENT API
     |====================================================== */
    public function initiateUssdPush(
        float $amount,
        string $phoneNumber,
        string $orderReference,
        string $currency = 'TZS'
    ): array {
        return $this->request(
            'post',
            '/third-parties/payments/initiate-ussd-push-request',
            [
                'amount'         => (string) $amount,
                'currency'       => $currency,
                'orderReference' => $orderReference,
                'phoneNumber'    => $this->formatPhoneNumber($phoneNumber),
            ]
        );
    }
  
    
    /**
     * ✅ CORRECT PAYMENT STATUS CHECK
     */
    public function getPaymentStatus(string $reference): array
    {
        if (empty($reference)) {
            throw new InvalidArgumentException('Payment reference cannot be empty');
        }
        return $this->request(
            'get',
            "/third-parties/payments/{$reference}"
        );
    }



    /**
 *  Format Tanzanian phone numbers
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
