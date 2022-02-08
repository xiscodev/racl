<?php

namespace Xiscodev\Racl\Responser;

use Illuminate\Http\Response;

trait RaclResponser
{
    /**
     * Build a success response.
     *
     * @param array|string $data
     * @param int          $code
     *
     * @return Illuminate\Http\JsonResponse
     */
    public static function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    /**
     * Build error responses.
     *
     * @param string $message
     * @param int    $code
     *
     * @return Illuminate\Http\JsonResponse
     */
    public static function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
