<?php

namespace Xiscodev\Racl\Http;

use GuzzleHttp\Client as HttpClient;

class AsyncClient
{
    /**
     * Holds the response type used to requests the API, possible values are
     * json, extjs, html, text, png.
     * @var string
     */
    private $responseType;

    /**
     * Holds the fake response type, it is useful when you want to get the JSON
     * raw string instead of a PHP array.
     * @var string
     */
    private $fakeType;

    /**
     * Constructor
     */
    public function __construct(
        $responseType = 'json',
        HttpClient $httpClient = null
    ) {
        $this->setHttpClient($httpClient);
        $this->setResponseType($responseType);
    }

    /**
     * Send a request to a given resource.
     * @return \Guzzle\Http\Message\Response
     * @throws \InvalidArgumentException If the given HTTP method is not one of
     *                                   'GET', 'POST', 'PUT', 'DELETE',
     */
    private function requestResource($actionPath, $params = [], $method = 'GET')
    {
        $url = $actionPath;

        if ($method != 'GET') {
            $headers = [];
        }

        switch ($method) {
            case 'GET':
                return $this->httpClient->get($url, [
                    'verify' => false,
                    'exceptions' => false,
                    'query' => $params,
                ]);

                break;
            case 'POST':
                return $this->httpClient->post($url, [
                    'verify' => false,
                    'exceptions' => false,
                    'form_params' => $params,
                ]);

                break;
            case 'PUT':
                return $this->httpClient->put($url, [
                    'verify' => false,
                    'exceptions' => false,
                    'form_params' => $params,
                ]);

                break;
            case 'DELETE':
                return $this->httpClient->delete($url, [
                    'verify' => false,
                    'exceptions' => false,
                    'form_params' => $params,
                ]);

                break;
            default:
                $errorMessage = "HTTP Request method {$method} not allowed.";

                throw new \InvalidArgumentException($errorMessage);
        }
    }

    /**
     * Parses the response to the desired return type.
     * @param string $response Response sent.
     * @return mixed The parsed response, depending on the response type can be
     *               an array or a string.
     */
    private function processHttpResponse($response)
    {
        switch ($this->fakeType) {
            case 'pngb64':
                $base64 = base64_encode($response->getBody());

                return 'data:image/png;base64,' . $base64;

                break;
            case 'object': // 'object' not supported yet, we return array instead.
            case 'array':
                // return $response->json();
                $response = json_decode($response->getBody()->getContents(), true);

                return json_encode($response);

                break;
            default:
                $response = json_decode($response->getBody()->__toString(), true);

                return json_encode($response);
        }
    }

    /**
     * Sets the HTTP client to be used to send requests over the network, for
     * now Guzzle needs to be used.
     * @param \GuzzleHttp\Client
     */
    public function setHttpClient($httpClient = null)
    {
        $this->httpClient = $httpClient ?: new HttpClient();
    }

    /**
     * Sets the response type that is going to be returned when doing requests.
     * @param string $responseType One of json, html, extjs, text, png.
     */
    public function setResponseType($responseType = 'array')
    {
        $supportedFormats = ['json', 'html', 'extjs', 'text', 'png'];

        if (in_array($responseType, $supportedFormats)) {
            $this->fakeType = false;
            $this->responseType = $responseType;
        } else {
            switch ($responseType) {
                case 'pngb64':
                    $this->fakeType = 'pngb64';
                    $this->responseType = 'png';

                    break;
                case 'object':
                case 'array':
                    $this->responseType = 'json';
                    $this->fakeType = $responseType;

                    break;
                default:
                    $this->responseType = 'json';
                    $this->fakeType = 'array'; // Default format
            }
        }
    }

    /**
     * Returns the response type that is being used by the client.
     *
     * @return string Response type being used.
     */
    public function getResponseType()
    {
        return $this->fakeType ?: $this->responseType;
    }

    /**
     * GET a resource defined.
     * @param string $actionPath The resource tree path you want to ask for
     * @param array $params      An associative array filled with params.
     * @return array             A PHP array json_decode($response, true).
     * @throws \InvalidArgumentException If given params are not an array.
     */
    public function get($actionPath, $params = [])
    {
        if (! is_array($params)) {
            $errorMessage = 'GET params should be an associative array.';

            throw new \InvalidArgumentException($errorMessage);
        }

        $response = $this->requestResource($actionPath, $params);

        return $this->processHttpResponse($response);
    }

    /**
     * SET a resource defined.
     * @param string $actionPath The resource tree path you want to ask for
     * @param array $params      An associative array filled with params.
     * @return array             A PHP array json_decode($response, true).
     * @throws \InvalidArgumentException If given params are not an array.
     */
    public function set($actionPath, $params = [])
    {
        if (! is_array($params)) {
            $errorMessage = 'PUT params should be an associative array.';

            throw new \InvalidArgumentException($errorMessage);
        }

        $response = $this->requestResource($actionPath, $params, 'PUT');

        return $this->processHttpResponse($response);
    }

    /**
     * CREATE a resource as defined.
     * @param string $actionPath The resource tree path you want to ask for
     * @param array $params      An associative array filled with POST params
     * @return array             A PHP array json_decode($response, true).
     * @throws \InvalidArgumentException If given params are not an array.
     */
    public function create($actionPath, $params = [])
    {
        if (! is_array($params)) {
            $errorMessage = 'POST params should be an asociative array.';

            throw new \InvalidArgumentException($errorMessage);
        }

        $response = $this->requestResource($actionPath, $params, 'POST');

        return $this->processHttpResponse($response);
    }

    /**
     * DELETE a resource defined.
     * @param string $actionPath The resource tree path you want to ask for
     * @param array $params      An associative array filled with params.
     * @return array             A PHP array json_decode($response, true).
     * @throws \InvalidArgumentException If given params are not an array.
     */
    public function delete($actionPath, $params = [])
    {
        if (! is_array($params)) {
            $errorMessage = 'DELETE params should be an associative array.';

            throw new \InvalidArgumentException($errorMessage);
        }

        $response = $this->requestResource($actionPath, $params, 'DELETE');

        return $this->processHttpResponse($response);
    }
}
