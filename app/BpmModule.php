<?php

namespace App;

use App\User;
use App\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;

class BpmModule
{
    private $api_url, $username, $password, $cookies, $headers;

    public function __construct()
    {
        $this->api_url  = getenv('BPM_MODULE_URI');
        $this->username = getenv('BPM_MODULE_USERNAME');
        $this->password = getenv('BPM_MODULE_PASSWORD');
        $this->cookies  = '';
        $this->headers  = [
            'MaxDataServiceVersion' => '3.0',
            'Content-Type' => 'application/json;odata=verbose',
            'DataServiceVersion' => '1.0'
        ];
    }

    public function contact(User $user)
    {
        $link = '/0/rest/UsrWebIntegrationService/Contact';
        $this->checkCookies();
        return request($link, [
            'request' => [
                'UserId' => $user->id,
                'Email'  => $user->email
            ]
        ]);
    }

    public function order(Order $order)
    {
        $link = '/0/rest/UsrWebIntegrationService/Order';
        $this->checkCookies();
        return request($link, [
            'request' => [
                'UserId'                => $order->user_id,
                'SourceCurrencyId'      => $order->source_currency_id,
                'DestinationCurrencyId' => $order->destination_currency_id,
                'SourceAssetId'         => $order->source_asset_id,
                'DestinationAssetId'    => $order->destination_asset_id,
                'RateSourceId'          => $order->rate_source_id,
                'FixPrice'              => $order->fix_price,
                'SourcePriceIndex'      => $order->source_price_index,
                'LimitFrom'             => $order->limit_from,
                'LimitTo'               => $order->limit_to
            ]
        ]);
    }


    private function checkCookies()
    {
        if (empty($this->cookies) || $this->cookies == ';') {
            $this->getCookies();
        }
    }

    private function getCookies()
    {
        $link = '/ServiceModel/AuthService.svc/Login';
        $credentials = ['UserName' => $this->username, 'UserPassword' => $this->password];
        $result = $this->request($link, $credentials);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
        $this->cookies = $matches[1][1].';'.$matches[1][2];
    }

    private function request($link, $body)
    {
        $options = [
            'headers' => $this->headers,
            'cookies' => $this->cookies
        ];
        $response = $this->client->request('POST', $this->api_url.$link, $options, $body);
        return json_decode($response->getBody()->getContents());
    }
}