<?php

namespace App;

use App\User;
use App\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;

class SyncModule
{
    private $api_url, $account, $headers;

    public function __construct()
    {
        $this->api_url  = getenv('BPM_MODULE_URI');
        $this->account  = getenv('BPM_MODULE_USERNAME').':'.getenv('BPM_MODULE_PASSWORD');
        $this->headers  = [
            'MaxDataServiceVersion' => '3.0',
            'Content-Type'          => 'application/json;odata=verbose',
            'DataServiceVersion'    => '1.0',
            'Authorization'         => 'Basic '.base64_encode($this->account))
        ];
    }

    public function contact(User $user)
    {
        $link = 'ContactCollection';
        return request($link, [
            'UsrUserId' => $user->id,
            'Email'     => $user->email
        ]);
    }

    public function order(Order $order)
    {
        $link = 'UsrOrderCollection';
        return request($link, [
            'UsrUserId'                => $order->user_id,
            'UsrSourceCurrencyId'      => $order->source_currency_id,
            'UsrDestinationCurrencyId' => $order->destination_currency_id,
            'UsrSourceAssetId'         => $order->source_asset_id,
            'UsrDestinationAssetId'    => $order->destination_asset_id,
            'UsrRateSourceId'          => $order->rate_source_id,
            'UsrFixPrice'              => $order->fix_price,
            'UsrSourcePriceIndex'      => $order->source_price_index,
            'UsrLimitFrom'             => $order->limit_from,
            'UsrLimitTo'               => $order->limit_to
        ]);
    }

    private function request($link, $body)
    {
        $response = $this->client->request(
            'POST',
            $this->api_url.$link,
            ['headers' => $this->headers],
            json_encode($body)
        );
        return json_decode($response->getBody()->getContents());
    }
}