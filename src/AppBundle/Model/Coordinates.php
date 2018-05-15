<?php
/**
 * Created by PhpStorm.
 * User: belov
 * Date: 15.05.18
 * Time: 1:00
 */

namespace AppBundle\Model;


class Coordinates implements IToString
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toString() : string
    {
        return $this->latitude . ', ' . $this->longitude;
    }
}