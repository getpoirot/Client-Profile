<?php
namespace Poirot\ProfileClient\Client\Folio\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ProfileClient\Client\Command\tTokenAware;
use Poirot\Std\Hydrator\HydrateGetters;


class FolioAvatarHash
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;


    protected $folioId;
    protected $avatarHash;
    protected $asPrimary;


    /**
     * FolioAvatarHash constructor.
     *
     * @param string $folioId
     * @param string $avatarHash
     * @param bool   $asPrimary
     */
    function __construct($folioId, $avatarHash, $asPrimary = true)
    {
        $this->folioId    = $folioId;
        $this->avatarHash = $avatarHash;
        $this->asPrimary  = (bool) $asPrimary;
    }


    // Options

    /**
     * @return string
     */
    function getFolioId()
    {
        return $this->folioId;
    }

    /**
     * @return string
     */
    function getAvatarHash()
    {
        return $this->avatarHash;
    }

    /**
     * @return boolean
     */
    function isAsPrimary()
    {
        return $this->asPrimary;
    }


    // ..

    /**
     * @ignore
     * @return HydrateGetters
     */
    function getIterator()
    {
        $hydrator = new HydrateGetters($this);
        $hydrator->setExcludeNullValues();
        return $hydrator;
    }
}
