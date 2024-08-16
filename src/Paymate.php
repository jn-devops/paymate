<?php

namespace Homeful\Paymate;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Paymate
{
    public function payment_qrph(Request $request)
    {
        $config = config('paymate');
        $transactionID = $request->input('referenceCode').time();
        $amount = $request->input('amount');
        $nonce_str = $request->input('referenceCode');
        $reqURL = 'body=RaemulanLandsInc&device_info=100&mch_create_ip=127.0.0.1&mch_id='.$config['merchant_id'].'&nonce_str='.$nonce_str.'&notify_url='.$config['notifyurl'].'&out_trade_no='.$transactionID.'&service=pay.instapay.native.v2&sign_type=SHA256&total_fee='.$amount.'&key=a0b1b6529b9a90efb5a80eba6ba0a7c6';
        $sign = hash('sha256', $reqURL);

        // Load XML template
        $xmlContent = simplexml_load_file(__DIR__.'\..\resources\xml\qrph_xml_template.xml');
        $xmlTemplate = $xmlContent->asXML();

        // dd( $xmlString);
        // $xmlTemplate = Storage::get('/qrph_xml_template.xml');
        if (! $xmlTemplate) {
            return 'Please setup qrph xml template(qrph_xml_template.xml) in storage/app.';
        }
        $xml_body = str_replace(['{{merchantID}}', '{{nonce_str}}', '{{transactionID}}', '{{notify_url}}', '{{amount}}', '{{sign}}'],
            [$config['merchant_id'], $nonce_str, $transactionID, $config['notifyurl'], $amount, $sign], $xmlTemplate);
        $client = new Client;
        try {
            $response = $client->post('https://gateway.wepayez.com/pay/gateway', ['headers' => ['Content-Type' => 'application/xml'], 'body' => $xml_body]);
            $xml_response = $this->parseXMLtoJSON($response->getBody()->getContents());

            return $xml_response;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error making payment: '.$e->getMessage()], 500);
        }
    }

    public function payment_wallet(Request $request)
    {
        $config = config('paymate');
        if ($request->input('wallet') == 'gcash') {
            $service = 'pay.gcash.webpay';
        } elseif ($request->input('wallet') == 'grabpay') {
            $service = 'pay.grab.webpay';
        }
        $transactionID = $request->input('referenceCode').time(); //referenceCode
        $amount = $request->input('amount');
        $nonce_str = $request->input('referenceCode');
        $reqURL = 'body=RaemulanLandsInc&callback_url='.$config['callback'].'&device_info=100&mch_create_ip=127.0.0.1&mch_id='.$config['merchant_id'].'&nonce_str='.$nonce_str.'&notify_url='.$config['notifyurl'].'&out_trade_no='.$transactionID.'&service='.$service.'&sign_type=SHA256&total_fee='.$amount.'&key=a0b1b6529b9a90efb5a80eba6ba0a7c6';
        $sign = hash('sha256', $reqURL);

        // Load XML template
        $xmlContent = simplexml_load_file(__DIR__.'\..\resources\xml\ewallet_xml_template.xml');
        $xmlTemplate = $xmlContent->asXML();

        // $xmlTemplate = Storage::get('/ewallet_xml_template.xml');
        if (! $xmlTemplate) {
            return 'Please setup ewallet xml template(ewallet_xml_template.xml) in storage/app.';
        }
        $xml_body = str_replace(
            ['{{merchantID}}', '{{callback_url}}', '{{nonce_str}}', '{{transactionID}}', '{{service}}', '{{notify_url}}', '{{amount}}', '{{sign}}'],
            [$config['merchant_id'], $config['callback'], $nonce_str, $transactionID, $service, $config['notifyurl'], $amount, $sign], $xmlTemplate);

        $client = new Client;
        try {
            $response = $client->post('https://gateway.wepayez.com/pay/gateway', [
                'headers' => [
                    'Content-Type' => 'application/xml',
                ],
                'body' => $xml_body,
            ]);
            $xml_response = $this->parseXMLtoJSON($response->getBody()->getContents());

            return $xml_response;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error making payment: '.$e->getMessage()], 500);
        }

    }

    public function payment_cashier(Request $request)
    {

        $config = config('paymate');
        $transactionID = time().$request->input('referenceCode');
        $reqBody = [
            'orderInformation' => [
                'amount' => $request->input('amount'),
                'orderId' => $request->input('referenceCode'),
                'attach' => 'attach',
                'goodsDetail' => 'Processing Fee',
                'callbackUrl' => $config['callback'],
                'notifyUrl' => $config['notifyurl'],
            ],
        ];

        try {
            $signStr = $this->createJwsSign($reqBody, $config['merpubkey']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating JWT signature: '.$e->getMessage()], 500);
        }

        $client = new Client;
        try {
            $response = $client->post($config['base_url'].'/cashier/v1/payment', [
                'json' => $reqBody,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Merchant-Id' => $config['merchant_id'],
                    'Customer-Request-Id' => $transactionID,
                    'Accept-Language' => 'en-US',
                    'Authorization' => $signStr,
                ],
            ]);
            $response_message = json_encode(json_decode($response->getBody()), JSON_UNESCAPED_SLASHES);

            // dd($response_message);
            return $response_message;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error making payment: '.$e->getMessage()], 500);
        }
    }

    public function payment_online(Request $request)
    {
        $config = config('paymate');
        $transactionID = $request->input('referenceCode').time();
        $ccNo = utf8_encode($request->input('pan'));
        $ccCode = utf8_encode($request->input('securityCode'));
        $cardNo = $this->jweEncryptionShell($config['jwekey'], $ccNo);
        // dd($cardNo);
        $cardCode = $this->jweEncryptionShell($config['jwekey'], $ccCode);
        $reqBody = [
            'createToken' => true,
            'customerInformation' => [
                'firstName' => 'null',
                'lastName' => null,
            ],
            'orderInformation' => [
                'amount' => $request->input('amount'),
                // 'orderId' => $request->input('referenceCode'),
                'orderId' => $transactionID,
                'attach' => 'attach',
                'goodsDetail' => 'Processing Fee',
                'callbackUrl' => $config['callback'],
                'notifyUrl' => $config['notifyurl'],
            ],
            'card' => [
                'expirationYear' => $request->input('expirationYear'),
                'securityCode' => $cardCode,
                'expirationMonth' => $request->input('expirationMonth'),
                'pan' => $cardNo,
            ],
        ];
        try {
            $signStr = $this->createJwsSign($reqBody, $config['merpubkey']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating JWT signature: '.$e->getMessage()], 500);
        }
        $client = new Client;
        try {
            $response = $client->post($config['base_url'].'/online/v1/payment', [
                'json' => $reqBody,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Merchant-Id' => $config['merchant_id'],
                    'Customer-Request-Id' => $request->input('referenceCode'), //$transactionID,
                    'Accept-Language' => 'en-US',
                    'Authorization' => $signStr,
                ],
            ]);
            $response_message = json_decode($response->getBody()); //json_encode(json_decode($response->getBody()),JSON_UNESCAPED_SLASHES);
            if ($response_message->code != '00' && $response_message->code != '98') {    //send email if not success
                $response = $this->email_qrph($request);

                return [$response, $response_message];
            }

            return $response_message;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error making payment: '.$e->getMessage()], 500);
        }
    }

    public function email_qrph($request)
    {
        // $config = config('paymate');
        $client = new Client;
        $generate_QR = $this->payment_qrph($request); //generate QRPH URL

        $json_input = ['qrdetails' => $generate_QR, 'email' => $request->email, 'buyerName' => $request->buyerName];
        try {
            $response = $client->request('POST', 'https://eoktie2n2pdyofg.m.pipedream.net', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $json_input,
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error making payment: '.$e->getMessage()], 500);
        }

    }

    public function parseXMLtoJSON($xml_response)
    {
        // Retrieve XML content from the request body
        $xmlString = $xml_response;
        $xmlObject = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xmlObject === false) {
            return response()->json(['error' => 'Error parsing XML'], 400);
        }
        $jsonString = json_encode($xmlObject, JSON_UNESCAPED_SLASHES);
        $jsonArray = json_decode($jsonString, true);

        return $jsonArray;
        // return json_encode(response()->json($jsonArray)->getData(),JSON_UNESCAPED_SLASHES);
    }

    public function jweEncryptionShell($publicKey, $payload)
    {
        // $encrypt = base_path('/resources/js/jweEncryption.cjs');
        $encrypt = __DIR__.'\..\resources\js\jweEncryption.cjs';
        // dd($encrypt);
        if (! file_exists($encrypt)) {
            return 'Encryption script not found';
        }
        $command = "node $encrypt ".escapeshellarg($publicKey).' '.escapeshellarg($payload);
        $output = [];
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            $jwe = json_decode(implode("\n", $output), true);

            return $jwe;
        } else {
            return response()->json(['error' => 'Encryption failed', 'output' => $output, 'resultCode' => $resultCode], 500);
        }

    }

    public function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function createJwsHeader()
    {
        $jwsHeader = [
            'alg' => 'RS256',
            'timestamp' => (string) time(),
        ];

        return rtrim(strtr(base64_encode(json_encode($jwsHeader)), '+/', '-_'), '=');
    }

    public function signBySHA256WithRSA($content, $privateKey)
    {
        $privateKeyResource = openssl_pkey_get_private("-----BEGIN PRIVATE KEY-----\n".wordwrap($privateKey, 64, "\n", true)."\n-----END PRIVATE KEY-----");
        if (! $privateKeyResource) {
            throw new \Exception('Invalid private key.');
        }
        openssl_sign($content, $signature, $privateKeyResource, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKeyResource);

        return rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
    }

    public function createJwsSign($reqBody, $privateKey)
    {
        if (! $privateKey) {
            throw new \Exception('Missing signing private key');
        }
        $jwsHeaderBase64 = $this->createJwsHeader();
        $jwsPayloadBase64 = rtrim(strtr(base64_encode(json_encode($reqBody)), '+/', '-_'), '=');
        $sign = $jwsHeaderBase64.'.'.$jwsPayloadBase64;
        $signBySHA256 = $this->signBySHA256WithRSA($sign, $privateKey);

        return $jwsHeaderBase64.'..'.$signBySHA256;
    }
}
