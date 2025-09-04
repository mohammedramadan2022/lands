<?php

namespace App\Services;

use App\Models\ThawaniOnlinePayment;
use Exception;

class ThawaniOnlinePaymentService
{
    protected $mode;
    protected $publishable_key;
    protected $secret_key;
    protected $base_url;

    public function __construct($publishable_key, $secret_key)
    {
        $this->mode = config('thawani.mode');

        $this->publishable_key = $publishable_key;

        $this->secret_key = $secret_key;

        if ($this->mode == 'test') {
            $this->base_url = 'https://uatcheckout.thawani.om/api/v1';
        } else {
            $this->base_url = 'https://checkout.thawani.om/api/v1';
        }

    }

    public function createCheckoutSession($name, $amount, $user_id,$subscription_id,$currency)
    {
        $curl = curl_init();
        $jsonencode = json_encode([
            "client_reference_id" => now(),
            "mode" => "payment",
            "total_amount"=> $amount * 1000,
            "currency"=> "EGP",
            "products" => [
                [
                    "name" => $name,
                    "quantity" => 1,
                    "unit_amount" => $amount * 1000
                ]
            ],
            "success_url" => config('thawani.success_url'),
            "cancel_url" => config('thawani.cancel_url'),
            "metadata" => [
                "username" => $user_id,
                "subscription_id" => $subscription_id,
            ]
        ], JSON_THROW_ON_ERROR);

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url . '/checkout/session',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonencode,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'thawani-api-key: ' . $this->secret_key
            ]
        ]);

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if ($response->success == true && $response->code == 2004) {
            $this->saveThawaniOnlinePayment($response);
            return $response;
        } else {
            return $response;
            throw new Exception($response->description);
        }
    }

    private function saveThawaniOnlinePayment($thawani_online_payment)
    {
        ThawaniOnlinePayment::create([
            'session_id' => $thawani_online_payment->data->session_id,
            'invoice_id' => $thawani_online_payment->data->invoice,
            'code' => $thawani_online_payment->code,
            'description' => $thawani_online_payment->description,
            'amount' => ($thawani_online_payment->data->total_amount) / 1000,
            'data' => $thawani_online_payment,
            'status' => $thawani_online_payment->data->payment_status,
        ]);

        return true;
    }

    public function getPayURL($session_id)
    {
        if ($this->mode == 'test') {
            return "https://uatcheckout.thawani.om/pay/{$session_id}?key=" . $this->publishable_key;
        } else {
            return "https://checkout.thawani.om/pay/{$session_id}?key=" . $this->publishable_key;
        }
    }

    public function getCheckoutSession($session_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url . "/checkout/session/$session_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                'thawani-api-key: ' . $this->secret_key
            ],
        ]);

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if ($response->success == true && $response->code == 2000) {
            return $response;
        } else {
            return $response;
            throw new Exception($response->description);
        }
    }
}
