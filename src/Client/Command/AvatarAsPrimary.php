<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\Std\Hydrator\HydrateGetters;


class AvatarAsPrimary
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    protected $hash;
    protected $asPrimary;


    /**
     * Constructor.
     * @param string $avatarHash
     */
    function __construct($avatarHash, $primary)
    {
        $this->hash = (string) $avatarHash;
        $this->asPrimary = (bool) $primary;
    }


    /**
     * @ignore
     * @return string
     */
    function getHash()
    {
        return $this->hash;
    }

    /**
     * @return boolean
     */
    function getAsPrimary()
    {
        return ($this->asPrimary) ? 'true' : 'false';
    }


    // ..

    /**
     * @ignore
     */
    function getIterator()
    {
        $hyd = new HydrateGetters($this);
        $hyd->setExcludeNullValues();
        return $hyd;
    }
}
