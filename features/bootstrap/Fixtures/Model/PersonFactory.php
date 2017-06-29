<?php

namespace Fixtures\Model;

class PersonFactory
{
    /**
     * @return Person
     */
    public function create()
    {
        $person = new Person('Bob');
        $person->changeAddress(new Address('Dam', '1', 'Amsterdam'));
        $person->addPhoneNumber(new PhoneNumber('Home', '0201234567'));
        $person->addPhoneNumber(new PhoneNumber('Mobile', '0612345678'));

        return $person;
    }
}
