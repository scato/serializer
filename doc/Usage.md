Usage
=====

Installation
------------

The best way to install the serializer is through Composer:

``` bash
$ composer require scato/serializer
```

No further setup or configuration is needed.

Basic Usage
-----------

Suppose we have a Person class. It's a DTO, so it has public properties. No getters or setters.

``` php
class Person
{
    /**
     * @var string
     */
    public $name;
}
```

We can serialize an instance:

``` php
$person = new Person();
$person->name = 'Bob';

$serializer = SerializerFacade::create();
$string = $serializer->serialize($person, 'json');
```

This will result in the string:

``` json
{
  "name": "Bob"
}
```

We can deserialize that string again, using the same serializer:

``` php
$person = $serializer->deserialize($string, 'Person', 'json');
```

Supported Formats
-----------------

The following formats are supported:

  - JSON (use 'json')
  - XML (use 'xml')
  - URL encoding (use 'url')

Configuration
-------------

No setup or configuration is needed to serialize objects. To deserialize strings, the serializer should know the type of
each property on your object. You can use normal DocBlocks to do so.

For example, if a Person also has an Address and zero or more PhoneNumbers, just add `@var` tags like so:

``` php
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
```

