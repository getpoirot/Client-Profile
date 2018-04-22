<?php
namespace Poirot\ProfileClient\Client\PlatformRest;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ProfileClient\Client\Command\GetMyProfile;
use Poirot\ProfileClient\Client\Command\GetUserBasicProfile;
use Poirot\ProfileClient\Client\Command\RemoveAvatar;
use Poirot\ProfileClient\Client\Command\SaveProfile;
use Poirot\ProfileClient\Client\Command\UploadAvatar;


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
        switch ($cmMethod) {
            case 'saveprofile':
            case 'getmyprofile':
                /** @var SaveProfile $command */
                /** @var GetMyProfile $command */
                $base   = '/profile';
                break;
            case 'getuserbasicprofile':
                /** @var GetUserBasicProfile $command */
                if ( $command->getUid() )
                    $base = sprintf('/profile/-%s/basic', $command->getUid());
                else
                    $base = sprintf('/profile/u/%s/basic', $command->getUsername());
                break;
            case 'getuserfullprofile':
                /** @var GetUserBasicProfile $command */
                if ( $command->getUid() )
                    $base = sprintf('/profile/-%s/full', $command->getUid());
                else
                    $base = sprintf('/profile/u/%s/full', $command->getUsername());
                break;
            case 'getuserprofilepage':
                /** @var GetUserBasicProfile $command */
                if ( $command->getUid() )
                    $base = sprintf('/profile/-%s/page', $command->getUid());
                else
                    $base = sprintf('/profile/u/%s/page', $command->getUsername());
                break;
            case 'uploadavatar':
                /** @var UploadAvatar $command */
                $base   = '/profile/avatars';
                break;
            case 'removeavatar':
            case 'avatarasprimary':
                /** @var RemoveAvatar $command */
                $base = sprintf('/profile/avatars/%s', $command->getHash());
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
