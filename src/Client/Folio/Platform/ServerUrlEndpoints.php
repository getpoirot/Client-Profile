<?php
namespace Poirot\ProfileClient\Client\Folio\Platform;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ProfileClient\Client\Folio\Command\FolioAvatarHash;
use Poirot\ProfileClient\Client\Folio\Command\SaveFolio;


class ServerUrlEndpoints
{
    protected $serverBaseUrl;
    protected $command;


    /**
     * ServerUrlEndpoints constructor.
     *
     * @param $serverBaseUrl
     * @param $command
     */
    function __construct($serverBaseUrl, $command, $ssl = false)
    {
        $this->serverBaseUrl = (string) $serverBaseUrl;
        $this->command    = $command;
    }

    function __toString()
    {
        return $this->_getServerHttpUrlFromCommand($this->command);
    }


    // ..

    /**
     * Determine Server Http Url Using Http or Https?
     *
     * @param iApiCommand $command
     *
     * @return string
     * @throws \Exception
     */
    protected function _getServerHttpUrlFromCommand($command)
    {
        $base = null;

        $cmMethod = strtolower( (string) $command );
        switch ($cmMethod)
        {
            case 'savefolio':
                /** @var SaveFolio $command */
                $base   = '/folios';
                break;

            case 'folioavatarhash':
                /** @var FolioAvatarHash $command */
                $base = sprintf('/folios/%s/avatars', $command->getFolioId());
                break;

            default:
                throw new \RuntimeException(sprintf(
                    'Server Url For Command(%s) Not Found.'
                    , (string) $command
                ));
        }


        $serverUrl = rtrim($this->serverBaseUrl, '/');
        (! $base ) ?: $serverUrl .= '/'. trim($base, '/');
        return $serverUrl;
    }
}
