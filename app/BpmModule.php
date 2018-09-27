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
            case 'App\Bank':
                return $this->bank($model); break;
            case 'App\Currency':
                return $this->currency($model); break;
            case 'App\DealStage':
                return $this->dealStage($model); break;
            case 'App\RateSource':
                return $this->rateSource($model); break;
            case 'App\AssetType':
                return $this->assetType($model); break;
            case 'App\Asset':
                return $this->asset($model); break;
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
        $this->saveModel($order, 'SLOrderCollection', [
            'SLName'                  => empty($order->name) ? "{$order->source_currency->symbol}->{$order->destination_currency->symbol}/{$order->user->email}" : $order->name,
            'SLContactIdId'           => $order->user->bpm_id,
            'SLSourceCurrency'        => $order->source_currency->name,
            'SLDestinationCurrency'   => $order->destination_currency->name,
            'SLSourceAsset'           => $order->source_asset->name,
            'SLDestinationAsset'      => $order->destination_asset->name,
            'SLRateSource'            => $order->rate_source->name,
            'SLFixPrice'              => empty($order->fix_price) ? "0" : strval($order->fix_price),
            'SLSourcePriceIndex'      => empty($order->source_price_index) ? "0" : strval($order->source_price_index),
            'SLLimitFrom'             => empty($order->limit_from) ? "0" : strval($order->limit_from),
            'SLLimitTo'               => empty($order->limit_to) ? "0" : strval($order->limit_to)
        ]);
        return $order;
    }

    public function assetType(AssetType $assetType)
    {
        $this->saveModel($assetType, 'SLAssetTypeCollection', [
            'Name'  => $assetType->name,
            'SLCrypto' => $assetType->crypto == 1
        ]);
        return $assetType;
    }

    public function asset(Asset $asset)
    {
        $this->saveModel($asset, 'SLAssetCollection', [
            'SLContactId' => $asset->user->bpm_id,
            'SLAssetTypeId' => $asset->asset_type->bpm_id,
            'SLCurrencyId' => empty($asset->currency) ? null : $asset->currency->bpm_id,
            'SLBankId' => empty($asset->bank) ? null : $asset->bank->bpm_id,
            'SLName'  => $asset->name,
            'SLAddress'  => $asset->address,
            'SLKey'  => $asset->key,
            'SLNotes'  => $asset->notes,
            'SLDefault' => $asset->default == 1,
        ]);
        return $asset;
    }

    public function bank(Bank $bank)
    {
        $this->saveModel($bank, 'SLBankCollection', [
            'Name' => $bank->name,
        ]);
        return $bank;
    }

    public function currency(Currency $currency)
    {
        $this->saveModel($currency, 'CurrencyCollection', [
            'Name' => $currency->name,
            'Symbol' => $currency->symbol,
            'Code' => $currency->symbol,
            'SLCrypto' => $currency->crypto == 1
        ]);
        return $currency;
    }

    public function dealStage(DealStage $dealStage)
    {
        $this->saveModel($dealStage, 'SLDealStageCollection', [
            'Name' => $dealStage->name
        ]);
        return $dealStage;
    }

    public function rateSource(RateSource $rateSource)
    {
        $this->saveModel($rateSource, 'SLRateSourceCollection', [
            'Name' => $rateSource->name,
            'SLDefault' => $rateSource->default == 1
        ]);
        return $rateSource;
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

