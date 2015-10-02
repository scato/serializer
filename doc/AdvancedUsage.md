Advanced Usage
==============

Custom type conversion can be performed using converters for serialization, and filters for deserialization.

Serialization Converters
------------------------

When you serialize an object, you can let it pass through a number of converters. For example, if you want
to convert every DateTime object to a string, you can create the following converter:

``` php
class CustomDateSerializationConverter implements SerializationConverterInterface
{
    public function convert($value)
    {
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d');
        }

        return $value;
    }
}
```

The next step is to simply add it to the Serializer:

``` php
$serializer = SerializerFacade::create();
$serializer->addSerializationConverter(new CustomDateSerializationConverter());
```

Converters are applied in reverse order (the converter that was added first will be applied last).

Deserialization Filters
-----------------------

When you deserialize a string, you can use a number of filters to change the output. For example, if you want
to create DateTime objects from strings, you can create the following filter:

``` php
class CustomDateDeserializationFilter implements DeserializationFilterInterface
{
    public function filter(Type $type, $value, ObjectFactoryInterface $next)
    {
        if ($type->toString() === 'DateTime') {
            return DateTime::createFromFormat('Y-m-d', $value);
        }

        return $next->createObject($type, $value);
    }
}
```

You might recognize the [Chain-of-responsibility pattern][link-corp] (also known as the Middleware Pattern). Each
filter is allowed to handle the creation of an object, or delegate it to the next filter in line.

Again, you just add the filter to the Serializer:

``` php
$serializer = SerializerFacade::create();
$serializer->addDeserializationFilter(new CustomDateDeserializationFilter());
```

Like serialization converters, these filters are also called in reverse order.

Custom Factories
----------------

Converters and filters allow you to do almost anything. There are some cases, however, that require you to write a
custom factory.

For example, if you want to limit the recursion depth, you would first write your own Navigator decorator:

```php
class MaxDepthNavigatorDecorator implements NavigatorInterface
{
    public function __construct(NavigatorInterface $parent)
    {
        $this->parent = $parent;
        $this->depth = 0;
    }

    public function accept(NavigatorInterface $navigator, VisitorInterface $visitor, $value)
    {
        if ($this->depth > 100) {
            $value = null;
        }

        $this->depth += 1;
        $this->parent->accept($navigator, $visitor, $value);
        $this->depth -= 1;
    }
}
```

You can then extend the JsonSerializerFactory like so:

```php
class CustomJsonSerializerFactory extends JsonSerializerFactory
{
    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new MaxDepthNavigatorDecorator(parent::createNavigator());
    }
}
```

Finally, you need a SerializerFacade that uses your serializer factory instead of the default one:

```php
$serializer = new SerializerFacade(['json' => new CustomJsonSerializerFactory()], [])
```

This serializer will only support JSON, and only for serialization, unless you add more factories.

For more help on how internals work, read the [internals](internals/Core.md) documentation.

[link-corp]: https://en.wikipedia.org/wiki/Chain-of-responsibility_pattern
