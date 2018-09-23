<?php
namespace Poirot\ProfileClient\Client\Folio;

use Poirot\ApiClient\aPlatform;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\Connection\HttpWrapper;
use Poirot\Http\HttpResponse;
use Poirot\ProfileClient\Client\Folio\Platform\ServerUrlEndpoints;
use Poirot\ProfileClient\Client\Response;
use Poirot\Std\Type\StdTravers;


class RestPlatformOfFolio
    extends aPlatform
    implements iPlatform
{
    /** @var iApiCommand */
    protected $Command;

    // Options:
    protected $usingSsl  = false;
    protected $serverUrl = null;


    // Alters

    protected function _SaveFolio(Command\SaveFolio $command)
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

    protected function _FolioAvatarHash(Command\FolioAvatarHash $command)
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
