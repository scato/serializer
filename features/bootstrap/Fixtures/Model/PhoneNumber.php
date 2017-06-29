<?php

namespace Fixtures\Model;

class PhoneNumber
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $number;

    /**
     * @param string $name
     * @param string $number
     */
    public function __construct($name, $number)
    {
        $this->name = $name;
        $this->number = $number;
    }
}