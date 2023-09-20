<?php

namespace App\Services;

use GuzzleHttp\Client;

class SendDataService
{
    protected $httpClient;

    private function getHttpClient()
    {
        if (!$this->httpClient) {
            // $this->httpClient = app('GuzzleClient')([
            $this->httpClient = new Client([
                'base_uri' => config('app.data_url'),
                'headers' => [
                    // 'Authorization' => 'Bearer ' . $this->getToken(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                // 'debug' => true
            ]);
        }
        return $this->httpClient;
    }

    public function getFileRates($parameters)
    {
        return $this->getHttpClient()->request('POST', '/api/get-file-rates', [
            'json' => [
                'parameters' => $parameters
            ]
        ])->getBody()->getContents();
    }

    public function sendRecLedgerData($parameters)
    {
        logger($parameters);
        return $this->getHttpClient()->request('POST', '/api/send-rec-lgr-data', [
            'json' => [
                'parameters' => $parameters
            ]
        ])->getBody()->getContents();
    }

    public function setRemoteUser($parameters)
    {
        return $this->getHttpClient()->request('POST', '/api/set-remote-user', [
            'json' => [
                'parameters' => $parameters
            ]
        ])->getBody()->getContents();
    }


    // public function getModifiedData($parameters)
    // {
    //     return $this->getHttpClient()->request('POST', '/api/get-modified-data', [
    //         'json' => [
    //             'parameters' => $parameters
    //         ]
    //     ])->getBody()->getContents();
    // }
}
