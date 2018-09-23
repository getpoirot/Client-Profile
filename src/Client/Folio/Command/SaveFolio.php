<?php
namespace Poirot\ProfileClient\Client\Folio\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ProfileClient\Client\Command\tTokenAware;
use Poirot\Std\ConfigurableSetter;
use Poirot\Std\Hydrator\HydrateGetters;


class SaveFolio
    extends ConfigurableSetter
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;


    protected $displayName;
    protected $description;
    protected $folioType;
    protected $folioContent;
    protected $stat;



    // Options:

    /**
     * @param mixed $displayName
     * @return $this
     */
    function setDisplayName($displayName)
    {
        $this->displayName = (string) $displayName;
        return $this;
    }

    /**
     * @return mixed
     */
    function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $description
     * @return $this
     */
    function setDescription($description)
    {
        $this->description = (string) $description;
        return $this;
    }

    /**
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Folio Type
     *
     * @param string $folioType
     *
     * @return $this
     */
    function setFolioType($folioType)
    {
        $this->folioType = (string) $folioType;
        return $this;
    }

    /**
     * Folio Type
     *
     * @return string
     */
    function getFolioType()
    {
        return $this->folioType;
    }

    /**
     * Folio Content
     *
     * @return array
     */
    function getFolioContent()
    {
        return $this->folioContent;
    }

    /**
     * Set Folio Content
     *
     * @param array $folioContent
     *
     * @return $this
     */
    function setFolioContent(array $folioContent)
    {
        $this->folioContent = $folioContent;
        return $this;
    }

    /**
     * Stat Publish
     *
     * @param string $stat
     */
    function setStat($stat)
    {
        $this->stat = $stat;
    }

    /**
     * Stat
     *
     * @return string
     */
    function getStat()
    {
        return $this->stat;
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
