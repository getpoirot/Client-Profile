<?php
namespace Poirot\ProfileClient;

use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\ProfileClient\Client\Command;
use Poirot\ApiClient\aClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ProfileClient\Client\PlatformRest;
use Poirot\ProfileClient\Client\Response;
use Poirot\ProfileClient\Exceptions\exTokenMismatch;
use Poirot\Psr7\UploadedFile;
use Poirot\Std\Struct\DataEntity;


/*
$c = new Client(
    'http://127.0.0.1'
    , new TokenProviderSolid(new AccessTokenObject([
        'access_token' => '7deb5600be908e074b3a'
    ]))
);


## Update Profile Data
#
$r = $c->meUpdateProfile(['location' => new GeoObject([
    'geo'     => ["39.721474", "59.437620"],
    'caption' => 'Yousef Abad'
])]);


## Upload Avatar From Request File
#
$data = ParseRequestData::_(\IOC::GetIoC()->get('/HttpRequest'))->parseBody();
$r = $c->meUploadAvatar($data['pic']);

## Upload File Stream
#
$file = $_FILES['pic']['tmp_name'];
$r = $c->meUploadAvatar(fopen($file, 'rb'));

 */

class Client
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


    /**
     * Update Profile Data Of Token Owner
     *
     * @param \Traversable|Command\SaveProfile $profileData
     *
     * @return array
     */
    function meUpdateProfile($profileData)
    {
        $command = ($profileData instanceof Command\SaveProfile)
            ? $profileData
            : new Command\SaveProfile($profileData);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Retrieve Profile Data Of Token Owner
     *
     * @return array
     */
    function meGetMyProfile()
    {
        $response = $this->call( new Command\GetMyProfile );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Upload an Avatar
     *
     * @param resource|UploadedFile $resource
     * @param bool                  $asPrimary Set as primary
     *
     * @return array
     */
    function meUploadAvatar($resource, $asPrimary = false)
    {
        $command = new Command\UploadAvatar($resource, $asPrimary);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Remove Uploaded Avatar By Given Hash
     *
     * @param string $avatarHash
     *
     * @return array
     */
    function meRemoveAvatar($avatarHash)
    {
        $command = new Command\RemoveAvatar($avatarHash);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Set Uploaded Avatar As Primary Profile Picture By Given Hash
     *
     * @param string $avatarHash
     * @param bool   $primary
     *
     * @return array
     */
    function meAvatarAsPrimary($avatarHash, $primary = true)
    {
        $command = new Command\AvatarAsPrimary($avatarHash, $primary);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }


    /**
     * Get Basic Info For Given User By UID
     * @param $uid
     * @return bool|mixed|null
     */
    function getBasicProfileByUid($uid)
    {
        $command = new Command\GetUserBasicProfile(['uid' => (string) $uid]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Get Basic Info For Given User By Username
     * @param $username
     * @return bool|mixed|null
     */
    function getBasicProfileByUsername($username)
    {
        $command = new Command\GetUserBasicProfile(['username' => (string) $username]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Get Basic Info For Given User By UID
     * @param $uid
     * @return bool|mixed|null
     */
    function getFullProfileByUid($uid)
    {
        $command = new Command\GetUserFullProfile(['uid' => (string) $uid]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Get Basic Info For Given User By Username
     * @param $username
     * @return bool|mixed|null
     */
    function getFullProfileByUsername($username)
    {
        $command = new Command\GetUserFullProfile(['username' => (string) $username]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Get Profile Page For Given User By UID
     * @param $uid
     * @return bool|mixed|null
     */
    function getProfilePageByUid($uid)
    {
        $command = new Command\GetUserProfilePage(['uid' => (string) $uid]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
    }

    /**
     * Get Profile Page For Given User By Username
     * @param $username
     * @return bool|mixed|null
     */
    function getProfilePageByUsername($username)
    {
        $command = new Command\GetUserProfilePage(['username' => (string) $username]);

        $response = $this->call( $command );
        if ( $ex = $response->hasException() )
            throw $ex;


        /** @var DataEntity $r */
        $r = $response->expected();
        return ($r) ? $r->get('result') : false;
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
            $this->platform = new PlatformRest;


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
