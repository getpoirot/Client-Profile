<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\Psr7\UploadedFile;
use Poirot\Std\Hydrator\HydrateGetters;


class UploadAvatar
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    protected $pic;
    protected $asPrimary;


    /**
     * UploadAvatar constructor.
     *
     * @param resource|UploadedFile $resource
     * @param bool                  $asPrimary
     */
    function __construct($resource, $asPrimary)
    {
        // TODO validate resource; arguments values

        $this->pic  = $resource;
        $this->asPrimary = (bool) $asPrimary;
    }

    /**
     * @return UploadedFile|resource
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * @return boolean
     */
    public function getAsPrimary()
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
