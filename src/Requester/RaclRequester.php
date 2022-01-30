<?php

namespace Xiscodev\Racl\Requester;

use Xiscodev\Racl\Http\AsyncClient;

trait RaclRequester
{
    /**
     * Send a request to any service.
     *
     * @param mixed $method
     * @param mixed $requestUrl
     * @param mixed $formParams
     * @param mixed $headers
     *
     * @return string
     */
    public static function performRequest($method, $requestUrl, $formParams = [], $headers = [])
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
