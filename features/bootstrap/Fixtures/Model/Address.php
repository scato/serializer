<?php

namespace Fixtures\Model;

class Address
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $city;

    /**
     * @param $street
     * @param $number
     * @param $city
     */
    public function __construct($street, $number, $city)
    {
        $this->street = $street;
        $this->number = $number;
        $this->city = $city;
    }
}