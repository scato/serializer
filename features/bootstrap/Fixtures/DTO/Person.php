<?php


namespace Fixtures\Dto;


class Person
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \Fixtures\Dto\Address
     */
    public $address;

    /**
     * @var \Fixtures\Dto\PhoneNumber[]
     */
    public $phoneNumbers;
}
