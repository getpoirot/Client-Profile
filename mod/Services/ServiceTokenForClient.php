<?php
namespace Module\ProfileClient\Services;

use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\Ioc\Container\Service\aServiceContainer;
use Poirot\OAuth2Client\Federation\TokenProvider\TokenFromOAuthClient;
use Poirot\OAuth2Client\Grant\Container\GrantPlugins;


class ServiceTokenForClient
    extends aServiceContainer
{
    const NAME = 'TokenProvider';
    /** @var string Service Name */
    protected $name = self::NAME;


    /**
     * Create Service
     *
     * @return iTokenProvider
     * @throws \Exception
     */
    function newService()
    {
        /** @var \Poirot\OAuth2Client\Client $oauthClient */
        $oauthClient   = $this->services()->get('/module/OAuth2Client/services/OAuthClient');
        $tokenProvider = new TokenFromOAuthClient(
            $oauthClient
            , $oauthClient->withGrant(GrantPlugins::CLIENT_CREDENTIALS, ['scopes' => ['profile']])
        );


        return $tokenProvider;
    }
}
