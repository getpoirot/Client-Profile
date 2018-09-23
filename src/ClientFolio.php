<?php
namespace Poirot\ProfileClient;

use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\Ioc\instance;
use Poirot\ProfileClient\Client\Folio\Command;
use Poirot\ApiClient\aClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ProfileClient\Client\Folio\RestPlatformOfFolio;
use Poirot\ProfileClient\Client\Response;
use Poirot\ProfileClient\Exceptions\exTokenMismatch;
use Poirot\Std\Interfaces\Struct\iData;
use Poirot\Std\Struct\DataEntity;


class ClientFolio
    extends aClient
{
    protected $serverUrl;
    protected $platform;
    protected $tokenProvider;


    /**
     * Constructor.
     *
     * @param string         $serverUrl
     * @param iTokenProvider $tokenProvider
     */
    function __construct($serverUrl, iTokenProvider $tokenProvider)
    {
        $this->serverUrl  = rtrim( (string) $serverUrl, '/' );
        $this->tokenProvider = $tokenProvider;
    }


    // Commands

    /**
     * Update Profile Data Of Token Owner
     *
     * @param \Traversable|Command\SaveFolio $folioData
     *
     * @return array
     */
    function saveFolio($folioData)
    {
        $command = ($folioData instanceof Command\SaveFolio)
            ? $folioData
            : new Command\SaveFolio($folioData);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r instanceof iData) ? $r->get('result') : false;
    }

    /**
     * Set Folio Avatar From Hash
     *
     * @param string $folioId
     * @param string $avatarHash
     * @param bool   $asPrimary
     *
     * @return array
     */
    function setFolioAvatarHash($folioId, $avatarHash, $asPrimary = true)
    {
        $command = new Command\FolioAvatarHash($folioId, $avatarHash, $asPrimary);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r instanceof iData) ? $r->get('result') : false;
    }


    // Options

    /**
     * Set Token Provider
     *
     * @param iTokenProvider $tokenProvider
     *
     * @return $this
     */
    function setTokenProvider(iTokenProvider $tokenProvider)
    {
        $this->tokenProvider = $tokenProvider;
        return $this;
    }

    /**
     * Server Url
     *
     * @return string
     */
    function getServerUrl()
    {
        return $this->serverUrl;
    }


    // Implement aClient

    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    protected function platform()
    {
        if (! $this->platform )
            $this->platform = new RestPlatformOfFolio;


        # Default Options Overriding
        $this->platform->setServerUrl( $this->serverUrl );

        return $this->platform;
    }


    // ..

    /**
     * @override handle token renewal from server
     *
     * @inheritdoc
     *
     * @return Response
     */
    protected function call(iApiCommand $command)
    {
        $recall = 1;

        recall:

        if (method_exists($command, 'setToken')) {
            $token = $this->tokenProvider->getToken();
            $command->setToken($token);
        }


        $response = parent::call($command);

        if ($ex = $response->hasException()) {

            if ( $ex instanceof exTokenMismatch && $recall > 0 ) {
                // Token revoked or mismatch
                // Refresh Token
                // TODO Handle Errors while retrieve token (delete cache)
                try {
                    $this->tokenProvider->exchangeToken();

                } catch (\Exception $e) {
                    // Exchange Not Implemented
                }

                $recall--;

                goto recall;
            }


            throw $ex;
        }


        return $response;
    }
}
