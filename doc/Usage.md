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

Advanced Usage
--------------

Currently there is no easy way to do advanced stuff like custom type handling or discriminator maps. What you *can* do
is replace one of the components with your own.

For example, if you want to use reflection to serialize objects with private fields, you could write your own
ObjectAccessor:

```php
class ReflectionAccessor implements ObjectAccessorInterface
{
    ...
}
```

You can then extend the JsonSerializerFactory like so:

```php
class CustomJsonSerializerFactory extends SerializerFactory
{
    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new Navigator(new ReflectionAccessor());
    }
}
```

Finally, you need a SerializerFacade that uses your serializer instead of the default one:

```php
$serializer = new SerializerFacade(['json' => new CustomJsonSerializerFactory()], [])
```

This serializer will only support JSON, and only for serialization, unless you add more factories.

Data Mapper
-----------

This library also contains a crude Data Mapper. It is not part of the SerializerFacade, you have to create it yourself:

```php
$factory = new DataMapperFactory();
$mapper = $factory->createMapper();
```

You can use this mapper to convert objects to arrays and vice versa:

```php
$array = $mapper->map($person, 'array');
$person = $mapper->map($array, 'Person');
```

You could use this to map `$_REQUEST` values or rows from a database.
