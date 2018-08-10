<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;

class BpmModule
{
    public  $api_url, $account, $headers, $client;

    public function __construct()
    {
        $this->client   = new Client();
        $this->api_url  = getenv('BPM_MODULE_URI');
        $this->account  = getenv('BPM_MODULE_USERNAME').':'.getenv('BPM_MODULE_PASSWORD');
        $this->headers  = [
            'Content-Type'          => 'application/json;odata=verbose',
            'Accept'                => 'application/json;odata=verbose',
            'Authorization'         => 'Basic '.base64_encode($this->account)
        ];
    }

    public function save($model)
    {
        switch (get_class($model)) {
            case 'App\User':
                return $this->contact($model); break;
            case 'App\Order':
                return $this->order($model); break;
            default:
                return null;
        }
    }



    public function contact(User $user)
    {
        $this->saveModel($user, 'ContactCollection', [
            'Email' => $user->email,
            'Name'  => $user->email
        ]);
        return $user;
    }

    public function order(Order $order)
    {
        $this->saveModel($order, 'UsrOrderCollection', [
            'UsrName'                  => "{$order->source_currency->symbol}->{$order->destination_currency->symbol}/{$order->user->email}",
            'UsrContactId'             => $order->user->bpm_id,
            'UsrSourceCurrency'        => $order->source_currency->name,
            'UsrDestinationCurrency'   => $order->destination_currency->name,
            'UsrSourceAsset'           => $order->source_asset->name,
            'UsrDestinationAsset'      => $order->destination_asset->name,
            'UsrRateSource'            => $order->rate_source->name,
            'UsrFixPrice'              => strval($order->fix_price),
            'UsrSourcePriceIndex'      => strval($order->source_price_index),
            'UsrLimitFrom'             => strval($order->limit_from),
            'UsrLimitTo'               => strval($order->limit_to)
        ]);
        return $order;
    }

    private function saveModel($model, $collection, $body)
    {
        if (empty($model->bpm_id))
        {
            $response = $this->request('POST', $collection, $body);
            $model->bpm_id = $response->d->Id;
            $model->save();
        }
        else {
            $this->request('PUT', "{$collection}(guid'{$model->bpm_id}')", $body);
        }
    }

    private function request($method, $link, $body = '')
    {
        $uri = $this->api_url . $link;
        $response = $this->client->request($method, $uri, [
            'body'    => \GuzzleHttp\json_encode($body),
            'headers' => $this->headers
        ]);
        Log::debug("BPM request {$method} to {$uri}", [
            'StatusCode' => $response->getStatusCode()
        ]);
        return $this->returnResponse($response);
    }

    private function returnResponse(Response $response)
    {
        if ($response->getStatusCode() =='400'){
            Log::debug("BPM response", [
                'StatusCode' => $response->getStatusCode(),
                'Message'    => $response->getBody()
            ]);
            return \response($response->getReasonPhrase(),$response->getStatusCode());
        }
        return json_decode($response->getBody());
    }
}

