<?php

namespace Xiscodev\Racl\HttpRequester;

use Xiscodev\Racl\Http\AsyncClient;

trait RaclRequester
{
    /**
     * Send a request to any service
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new AsyncClient();
        $request = null;

        switch ($method) {
            case 'GET':
                $request = $client->get($requestUrl, $formParams);

                break;
            case 'POST':
                $request = $client->create($requestUrl, $formParams);

                break;
            case 'PUT':
                $request = $client->set($requestUrl, $formParams);

                break;
            case 'DELETE':
                $request = $client->delete($requestUrl, $formParams);

                break;
            default:
                $request = $client->get($requestUrl, $formParams);

                break;
        }

        return $request;
    }
}
