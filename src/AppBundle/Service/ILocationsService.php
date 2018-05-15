<?php

namespace AppBundle\Service;

use AppBundle\Exceptions\MalformedJsonException;
use AppBundle\Model\PlaceOfInterest;

interface ILocationsService
{
    /**
     * @return PlaceOfInterest[]
     */
    public function getPlacesOfInterest() : array;
}