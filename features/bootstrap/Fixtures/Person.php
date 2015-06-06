<?php


namespace Fixtures;


class Person
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \Fixtures\Address
     */
    public $address;

    /**
     * @var \Fixtures\PhoneNumber[]
     */
    public $phoneNumbers;
}
