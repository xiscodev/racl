<?php

namespace Xiscodev\Racl\Requester;

use Xiscodev\Racl\Http\AsyncHttpClient;

/**
 * Allows to perform rest http requests.
 */
class RaclRequester
{
    /**
     * Send a request to any service.
     *
     * @param mixed $method
     * @param mixed $requestUrl
     * @param mixed $formParams
     * @param mixed $headers
     * @param mixed $cookies
     *
     * @return string
     */
    public static function performRequest(
        $method,
        $requestUrl,
        $formParams = [],
        $headers = [],
        $cookies = []
    ) {
        $client = new AsyncHttpClient();
        $request = null;

        switch ($method) {
        case 'GET':
            $request = $client->get(
                $requestUrl,
                $formParams,
                $headers,
                $cookies
            );

            break;

        case 'POST':
            $request = $client->create(
                $requestUrl,
                $formParams,
                $headers,
                $cookies
            );

            break;

        case 'PUT':
            $request = $client->set(
                $requestUrl,
                $formParams,
                $headers,
                $cookies
            );

            break;

        case 'DELETE':
            $request = $client->delete(
                $requestUrl,
                $formParams,
                $headers,
                $cookies
            );

            break;

        default:
            $request = $client->get(
                $requestUrl,
                $formParams,
                $headers,
                $cookies
            );

            break;
        }

        return $request;
    }
}
