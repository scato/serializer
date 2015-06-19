<?php


namespace Fixtures\Entity;


class Person
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Fixtures\Dto\Address
     */
    private $address;

    /**
     * @var \Fixtures\Dto\PhoneNumber[]
     */
    private $phoneNumbers;

    /**
     * @param integer $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Fixtures\Dto\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param \Fixtures\Dto\Address $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return \Fixtures\Dto\PhoneNumber[]
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @param \Fixtures\Dto\PhoneNumber[] $phoneNumbers
     */
    public function setPhoneNumbers($phoneNumbers)
    {
        $this->phoneNumbers = $phoneNumbers;
    }
}
