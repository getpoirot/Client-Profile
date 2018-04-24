<?php
namespace Module\ProfileClient\Services;

use Module\ProfileClient\Module;
use Poirot\Application\aSapi;
use Poirot\Ioc\Container\Service\aServiceContainer;
use Poirot\OAuth2Client\Federation\TokenProvider\TokenFromOAuthClient;
use Poirot\OAuth2Client\Grant\Container\GrantPlugins;
use Poirot\ProfileClient\Client;
use Poirot\Std\Struct\DataEntity;


class ServiceClientOfProfile
    extends aServiceContainer
{
    const NAME = 'ClientProfile';
    const CONF = 'client';

    /** @var string Service Name */
    protected $name = self::NAME;

    protected $serverUrl;


    /**
     * Create Service
     *
     * @return Client
     * @throws \Exception
     */
    function newService()
    {
        $serverUrl = $this->getServerUrl();

        /** @var \Poirot\OAuth2Client\Client $oauthClient */
        $oauthClient = $this->services()->get('/module/OAuth2Client/services/OAuthClient');
        $c = new Client(
            $serverUrl
            , new TokenFromOAuthClient(
                $oauthClient
                , $oauthClient->withGrant(GrantPlugins::CLIENT_CREDENTIALS, ['scopes' => ['profile']])
            )
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

    function getServerUrl()
    {
        if (! $this->serverUrl )
            $this->serverUrl = $this->_getConf(self::CONF, 'server_url');

        if ( empty($this->serverUrl) )
            throw new \Exception('Server Url For Client Profile Not Set.');


        return $this->serverUrl;
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
        array_shift($keyconfs);

        foreach ($keyconfs as $key) {
            if (! isset($config[$key]) )
                return null;

            $config = $config[$key];
        }

        return $config;
    }
}
