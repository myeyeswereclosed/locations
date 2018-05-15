<?php


namespace AppBundle\Model;


class PlaceOfInterest implements IToString
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Coordinates
     */
    private $coordinates;

    public function __construct(string $name,  Coordinates $coordinates)
    {
        $this->name = $name;
        $this->coordinates = $coordinates;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->name . ' has coordinates ' . $this->coordinates->toString();
    }
}