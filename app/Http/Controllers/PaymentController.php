<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.payment');
    }

    public function verify(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$request->transaction_id}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS =>10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => array(
                "Content-Type: application/json",
                "Authorization: Bearer FLWSECK_TEST-acecd1f971f3472c6cf178302afe9749-X"
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);

        return [$res];
    }
}
