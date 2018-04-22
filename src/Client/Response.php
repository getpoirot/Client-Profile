<?php
namespace Poirot\ProfileClient\Client;

use Poirot\ApiClient\Exceptions\exServerError;
use Poirot\ApiClient\Exceptions\exUnknownError;
use Poirot\ApiClient\HttpResponseOfClient;


class Response
    extends HttpResponseOfClient
{
    /**
     * // TODO handle token issues
     *
     * @param \Poirot\Std\Struct\DataEntity $expected
     */
    function doRecognizeErrorFromExpected($expected)
    {
        $error = $expected->get('error');
        if (! $error )
            // Unknown Error Happen
            throw new exUnknownError();


        switch ($error['state']) {
            default:
                throw new exServerError($error['state'].'::'.$error['message'], $error['code']);
        }
    }
}
