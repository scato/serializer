<?php


namespace Fixtures;


use Fixtures\Address;
use Fixtures\PhoneNumber;

class Person
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var PhoneNumber[]
     */
    public $phoneNumbers;
}
