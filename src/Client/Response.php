<?php
namespace Poirot\ProfileClient\Client;

use Poirot\ApiClient\Exceptions\exServerError;
use Poirot\ApiClient\Exceptions\exUnknownError;
use Poirot\ApiClient\HttpResponseOfClient;
use Poirot\Std\Interfaces\Struct\iDataEntity;


class Response
    extends HttpResponseOfClient
{
    /**
     * // TODO handle token issues
     *
     * @param \Poirot\Std\Struct\DataEntity $expected
     *
     * @throws \Exception
     */
    function doRecognizeErrorFromExpected($expected)
    {
        if (! $expected instanceof iDataEntity)
            throw new \Exception(sprintf(
                'Bad Data Response; get: (%s).'
                , \Poirot\Std\flatten($expected)
            ));


        $error = $expected->get('error');
        if (! $error )
            // Unknown Error Happen
            throw new exUnknownError();


        $url = (! $this->getMeta('_url_') )
            ?: ', When calling '. $this->getMeta('_url_');

        switch ($error['state']) {
            default:
                throw new exServerError(
                    $error['state'].'::'.$error['message'].$url
                    , $error['code']
                );
        }
    }
}
