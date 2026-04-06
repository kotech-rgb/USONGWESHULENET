<?php

namespace App\Http\Controllers;

use App\Models\Recharge;
use Illuminate\Http\Request;
use App\services\ClickPesaService;
use App\services\SmsService;
use App\Models\Configuration;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    

public function trackPendingPayments(ClickPesaService $clickPesaService, SmsService $smsService)
{
    // $companyName = auth()->user()->company_from;
    $mapStatus = function($status) {
        return match (strtoupper($status)) {
            'SETTLED' => 'PAID',
            'FAILED' => 'FAILED',
            'PROCESSING' => 'PROCESSING',
            default => 'PENDING',
        };
    };

    $recharges = Recharge::whereNotIn('status', ['PAID', 'FAILED'])->get();
    foreach ($recharges as $recharge) {
        $reference = $recharge->reference ?? $recharge->reference;
        if (!$reference) {
            continue;
        }
        $responseArray = $clickPesaService->getPaymentStatus($reference);
        if (!is_array($responseArray) || empty($responseArray)) {
            continue;
        }
        foreach ($responseArray as $response) {
            $mappedStatus = $mapStatus($response['status'] ?? 'PENDING');

            if ($recharge->status !== $mappedStatus) {
                $recharge->update(['status' => $mappedStatus]);
                if ($mappedStatus === 'PAID') {
                    $message="Hongera! Malipo yako kwaajili ya SMS bando yamepokelewa kikamilifu, kiwango cha SMS kimeongezeka kwenye Account yako. Asante kwa kutuamini";
                    $result = $smsService->DefaultSender($recharge->phone_number,$message,'SMSRechargeREF');
                    $companyModel = Configuration::first();
                    if ($companyModel) {
                        $newBalance = $companyModel->sms_balance + $recharge->SMS_amount;
                        $companyModel->update(['sms_balance' => $newBalance]);
                    }
                }
            }
        }
    }

    return response()->json([
        'senderPaymentsChecked' => count($senderPayments),
        'rechargesChecked' => count($recharges),
        'recharge' => $recharges->last() ?? null,
    ]);
}


    // silence 
    public function SMSReachargestatus($reference)
    {
        $recharge = Recharge::where('reference', $reference)->first();
        if (!$recharge) {
            return response()->json(['error' => 'Recharge not found'], 404);
        }
        return response()->json(['recharge' => $recharge]);
    }
    
    
}
