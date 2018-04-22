<?php
namespace Module\ProfileClient\Handler;

use Module\ProfileClient\Interfaces\iMediaHandler;
use Module\ProfileClient\Model\MediaObjectTenderBin;
use Poirot\ProfileClient\Client;
use Poirot\ProfileClient\Model\aMediaObject;


class HandleTenderBin
    implements iMediaHandler
{
    const STORAGE_TYPE = 'tenderbin';


    /**
     * Handler Can Handle Media Object By Storage Type
     *
     * @param string $storageType
     *
     * @return bool
     */
    function canHandleMedia($storageType)
    {
        return ($storageType == self::STORAGE_TYPE);
    }

    /**
     * Create new Media Object With Given Options
     *
     * @param \Traversable $mediaOptions
     *
     * @return aMediaObject
     */
    function newMediaObject($mediaOptions = null)
    {
        $objectMedia = new MediaObjectTenderBin;
        if (! empty($mediaOptions) )
            $objectMedia->with( $objectMedia::parseWith($mediaOptions) );


        return $objectMedia;
    }

    /**
     * Client
     *
     * @return Client
     */
    function client()
    {
        return $cTender = \Module\ProfileClient\Services::ClientTender();
    }

    function getType()
    {
        return self::STORAGE_TYPE;
    }
}
