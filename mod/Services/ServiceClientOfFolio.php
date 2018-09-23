<?php
namespace Module\ProfileClient\Services;

use Poirot\Ioc\instance;
use Module\ProfileClient\Module;
use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\Application\aSapi;
use Poirot\Ioc\Container\Service\aServiceContainer;
use Poirot\ProfileClient\ClientFolio;
use Poirot\Std\Struct\DataEntity;


class ServiceClientOfFolio
    extends aServiceContainer
{
    const NAME = 'ClientFolio';
    const CONF = 'client';

    /** @var string Service Name */
    protected $name = self::NAME;

    /** @var string */
    protected $serverUrl;
    /** @var iTokenProvider */
    protected $tokenProvider;


    /**
     * Create Service
     *
     * @return ClientFolio
     * @throws \Exception
     */
    function newService()
    {
        $c = new ClientFolio(
            $this->getServerUrl()
            , $this->getTokenProvider()
        );

        return $c;
    }


    // ..

    /**
     * @param mixed $serverUrl
     */
    function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;
    }

    /**
     * @param iTokenProvider $tokenProvider
     */
    function setTokenProvider(iTokenProvider $tokenProvider)
    {
        $this->tokenProvider = $tokenProvider;
    }

    function getServerUrl()
    {
        if (! $this->serverUrl )
            $this->serverUrl = $this->_getConf(self::CONF, 'server_url');

        if ( empty($this->serverUrl) )
            throw new \Exception('Server Url For Client Profile Not Set.');


        return $this->serverUrl;
    }

    function getTokenProvider()
    {
        if (! $this->tokenProvider )
        {
            $tokenProvider = $this->_getConf(self::CONF, 'token_provider');
            if (! $tokenProvider instanceof iTokenProvider)
                $tokenProvider = new instance($tokenProvider);

            $this->setTokenProvider($tokenProvider);
        }

        if ( empty($this->tokenProvider) )
            throw new \Exception('Token Provider For Client Profile is Empty.');


        return $this->tokenProvider;
    }


    // ..

    /**
     * Get Config Values
     *
     * Argument can passed and map to config if exists [$key][$_][$__] ..
     *
     * @param $key
     * @param null $_
     *
     * @return mixed|null
     * @throws \Exception
     */
    protected function _getConf($key = null, $_ = null)
    {
        // retrieve and cache config
        $services = $this->services();

        /** @var aSapi $config */
        $config = $services->get('/sapi');
        $config = $config->config();
        /** @var DataEntity $config */
        $config = $config->get(Module::CONF, []);


        ## Retrieve requested config key(s)
        #
        $keyconfs = func_get_args();
        foreach ($keyconfs as $key) {
            if (! isset($config[$key]) )
                return null;

            $config = $config[$key];
        }

        return $config;
    }
}
