<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\Std\ConfigurableSetter;
use Poirot\Std\Hydrator\HydrateGetters;
use Poirot\ValueObjects\GenderEnum;
use Poirot\ValueObjects\GeoObject;


class SaveProfile
    extends ConfigurableSetter
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;


    protected $displayName;
    protected $bio;
    protected $gender;
    /** @var \DateTime */
    protected $birthday;
    protected $location;


    // Options:

    /**
     * @return mixed
     */
    function getDisplayName()
    {
        return $this->displayName;
    }

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
    function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $bio
     * @return $this
     */
    function setBio($bio)
    {
        $this->bio = (string) $bio;
        return $this;
    }

    /**
     * @return mixed
     */
    function getGender()
    {
        if ($this->gender)
            return (string) $this->gender;
    }

    /**
     * @param mixed $gender
     * @return $this
     */
    function setGender(GenderEnum $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return \DateTime
     */
    function getBirthday()
    {
        if ($this->birthday)
            return $this->birthday->format('Y-m-d');
    }

    /**
     * @param \DateTime $birthday
     * @return $this
     */
    function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return GeoObject
     */
    function getLocation()
    {
        return $this->location;
    }

    /**
     * @param GeoObject $location
     * @return $this
     */
    function setLocation(GeoObject $location)
    {
        $this->location = $location;
        return $this;
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
