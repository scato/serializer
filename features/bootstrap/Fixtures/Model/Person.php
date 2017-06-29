<?php

namespace Fixtures\Model;

use SplDoublyLinkedList;

class Person
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var PhoneNumber[]
     */
    private $phoneNumbers;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->phoneNumbers = new SplDoublyLinkedList();
    }

    /**
     * @param Address $address
     * @return void
     */
    public function changeAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return void
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers->push($phoneNumber);
    }
}
