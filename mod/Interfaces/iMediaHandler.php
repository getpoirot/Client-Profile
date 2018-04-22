<?php
namespace Module\ProfileClient\Interfaces;

use Poirot\ProfileClient\Client;
use Poirot\ProfileClient\Model\aMediaObject;


interface iMediaHandler
{
    /**
     * Handler Can Handle Media Object By Storage Type
     *
     * @param string $storageType
     *
     * @return bool
     */
    function canHandleMedia($storageType);

    /**
     * Create new Media Object With Given Options
     *
     * @param \Traversable $mediaOptions
     *
     * @return aMediaObject
     */
    function newMediaObject($mediaOptions);

    /**
     * Client
     *
     * @return Client
     */
    function client();

    /**
     * @return string
     */
    function getType();
}
