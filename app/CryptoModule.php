<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;


/**
 * Class CryptoModule
 * @package App
 */
class CryptoModule
{
    /**
     * @var currency string
     */
    private $currency;


    /**
     * @var array|false|string
     */
    private $api_url;


    /**
     * @var Client http client
     */
    private $client;


    /**
     * CryptoModule constructor.
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        $this->currency = $currency;
        $this->api_url = getenv('CRYPTO_MODULE_URI');
        $this->client = new Client();
    }


    /**
     * @return \stdClass
     */
    public function getAddress(): \stdClass
    {
        $res = $this->client->request(
            'POST',
            $this->api_url . '/accounts/' . $this->currency,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]
        );
        return json_decode($res->getBody()->getContents());
    }

    /**
     * @param string $address
     * @return string
     */
    public function checkBalance(string $address)
    {
        $res = $this->client->request(
            'GET',
            $this->api_url . '/accounts/' . $this->currency . '/' .$address . '/balance',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]
        );
        return $this->returnResponse($res);
    }


    /**
     * @param string $accountFrom
     * @param string $privateKeyFrom
     * @param string $accountTo
     * @param string $amount
     * @return string
     */
    public function releaseTransaction(string $accountFrom, string $privateKeyFrom, string $accountTo, string $amount)
    {
        try{
        $res = $this->client->request(
            'POST',
            $this->api_url . '/transactions/' . $this->currency . '/fee-not-included',
            [
                'body'=>\GuzzleHttp\json_encode([
                    'to'=>$accountTo,
                    'fee'=>'Average',
                    'from'=> $accountFrom,
                    'fromPrivateKey'=> $privateKeyFrom,
                    'value'=>$amount,
                ]),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
            ]
        );
        }catch (ServerException $e){
            return false;
        }
        return $this->returnResponse($res);
    }

    /**
     * @param Response $response
     * @return string
     */
    private function returnResponse(Response $response): \stdClass
    {
        if ($response->getStatusCode()!='200'){
            return \response($response->getReasonPhrase(),$response->getStatusCode());
        }
        return json_decode($response->getBody()->getContents());
    }
}