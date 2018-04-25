<?php
namespace Poirot\ProfileClient\Client;

use Poirot\ApiClient\aPlatform;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\Connection\HttpWrapper;
use Poirot\Psr7\HttpResponse;
use Poirot\Std\Exceptions\exUnexpectedValue;
use Poirot\Std\Type\StdTravers;
use Poirot\ProfileClient\Client\PlatformRest\ServerUrlEndpoints;


// TODO using cache for commands
class PlatformRest
    extends aPlatform
    implements iPlatform
{
    /** @var iApiCommand */
    protected $Command;

    // Options:
    protected $usingSsl  = false;
    protected $serverUrl = null;


    // Alters



    protected function _SaveProfile(Command\SaveProfile $command)
    {
        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Command Data Arguments
        #
        $args = StdTravers::of($command)->toArray(null, true);


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->post($url, $args, $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _GetMyProfile(Command\GetMyProfile $command)
    {
        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->get($url, [], $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _GetUserBasicProfile(Command\GetUserBasicProfile $command)
    {
        if ( !($command->getUid() || $command->getUsername()) )
            throw new exUnexpectedValue();


        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->get($url, [], $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _GetUserFullProfile(Command\GetUserFullProfile $command)
    {
        if ( !($command->getUid() || $command->getUsername()) )
            throw new exUnexpectedValue();


        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->get($url, [], $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _GetUserProfilePage(Command\GetUserProfilePage $command)
    {
        if ( !($command->getUid() || $command->getUsername()) )
            throw new exUnexpectedValue();


        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->get($url, [], $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _UploadAvatar(Command\UploadAvatar $command)
    {
        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Command Data Arguments
        #
        $args = StdTravers::of($command)->toArray(null, true);


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->post($url, $args, $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _RemoveAvatar(Command\RemoveAvatar $command)
    {
        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->delete($url, [], $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }

    protected function _AvatarAsPrimary(Command\AvatarAsPrimary $command)
    {
        ## Headers
        #
        $headers = [
            'Accept' => 'application/json'
        ];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer '. ( $command->getToken()->getAccessToken() );


        ## Command Data Arguments
        #
        $args = StdTravers::of($command)->toArray(null, true);


        ## Send To Upstream Server
        #
        $url = $this->_getServerUrlEndpoints($command);

        $wrapper  = new HttpWrapper();
        /** @var HttpResponse $response */
        $response = $wrapper->send('PUT', $url, $args, $headers);


        ## Build Response
        #
        $response = new Response($response);
        return $response;
    }


    // Options

    /**
     * Set Server Url
     *
     * @param string $url
     *
     * @return $this
     */
    function setServerUrl($url)
    {
        $this->serverUrl = (string) $url;
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

    /**
     * Using SSl While Send Request To Server
     *
     * @param bool $flag
     *
     * @return $this
     */
    function setUsingSsl($flag = true)
    {
        $this->usingSsl = (bool) $flag;
        return $this;
    }

    /**
     * Ssl Enabled?
     *
     * @return bool
     */
    function isUsingSsl()
    {
        return $this->usingSsl;
    }


    // ..

    protected function _getServerUrlEndpoints($command)
    {
        $url = new ServerUrlEndpoints(
            $this->getServerUrl()
            , $command
            , $this->isUsingSsl()
        );

        return (string) $url;
    }
}
