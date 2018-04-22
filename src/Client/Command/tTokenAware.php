<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Token\iAccessTokenObject;


trait tTokenAware
{
    protected $token;


    function setToken(iAccessTokenObject $token)
    {
        $this->token = $token;
    }

    /**
     * @ignore
     * @return iAccessTokenObject
     */
    function getToken()
    {
        return $this->token;
    }
}
