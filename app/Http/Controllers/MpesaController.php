<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use Iankumu\Mpesa\Facades\Mpesa;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function initiateStkPush(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|regex:/^254[17]\d{8}$/', // Kenyan format
            'amount' => 'required|numeric|min:1',
            'account_reference' => 'required|string|max:12',
        ]);

        $response = Mpesa::stkpush(
            phonenumber: $validated['phone_number'],
            amount: $validated['amount'],
            account_number: $validated['account_reference'],
            transactionType: Mpesa::PAYBILL // Or Mpesa::TILL for Buy Goods
        );

        $result = $response->json();

        if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
            // Save initial request for tracking
            MpesaTransaction::create([
                'merchant_request_id' => $result['MerchantRequestID'],
                'checkout_request_id' => $result['CheckoutRequestID'],
                'phone_number' => $validated['phone_number'],
            ]);
            return response()->json(['message' => 'STK Push initiated successfully', 'data' => $result]);
        }

        return response()->json(['error' => 'STK Push failed', 'details' => $result], 400);
    }
}

