<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    //
    public function createPayment(Request $request)
    {
        // $client = new Client();
        // $response = $client->post('https://api.izipay.pe/v1/payments', [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . env('IZIPAY_API_KEY'),
        //     ],
        //     'json' => [
        //         'amount' => $request->amount,
        //         'currency' => 'PEN',
        //         'orderId' => 'order-' . uniqid(),
        //         'customer' => [
        //             'email' => $request->email,
        //         ],
        //     ],
        // ]);

        // return response()->json(json_decode($response->getBody()->getContents()));

        return response()->json(['message' => 'Payment created successfully']);
    }

    public function validatePayment(Request $request)
    {
        // Lógica para validar el pago
    }
}
