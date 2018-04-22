<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\Std\Hydrator\HydrateGetters;


class RemoveAvatar
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    protected $hash;


    /**
     * Constructor.
     * @param string $avatarHash
     */
    function __construct($avatarHash)
    {
        $this->hash = (string) $avatarHash;
    }


    /**
     * @return string
     */
    function getHash()
    {
        return $this->hash;
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
