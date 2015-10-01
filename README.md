# Serializer

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]

An alternative serializer that minimizes configuration, and is focused on DTOs instead of Entities.

## Install

Via Composer

``` bash
$ composer require scato/serializer
```

## Usage

``` php
$serializer = SerializerFacade::create();
$string = $serializer->serialize(..., 'json');
```

Read [the docs](doc/Usage.md) for more examples on how to use the serializer, or jump to
[Advanced Usage](doc/AdvancedUsage.md) to learn about custom type handling and custom factories.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Known issues

Composite types are not supported. If your type reads `array|Foo[]` or `string|null`, you're out of luck.

Deserialization does not support polymorphism. If a type says `Foo`, an object will never be deserialized as a subclass
of `Foo`. The reason for this is that DocBlocks have no way to define discriminators. (Maybe we could use the `@uses`
tag to point to a property with a default value, so the property/value-pair can be used as a discriminator.)

No caching is performed, which makes deserialization relatively slow.

There is a problem with the `phpdocumentor/reflection-common` component, so you have to add it to your own
`composer.json`:

``` json
  "require": {
    "phpdocumentor/reflection-common": "^1.0@dev"
  },
```

## Credits

- [Scato Eggen][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/scato/serializer.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/scato/serializer/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/scato/serializer.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/scato/serializer.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/scato/serializer.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/scato/serializer
[link-travis]: https://travis-ci.org/scato/serializer
[link-scrutinizer]: https://scrutinizer-ci.com/g/scato/serializer/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/scato/serializer
[link-downloads]: https://packagist.org/packages/scato/serializer
[link-author]: https://github.com/scato
[link-contributors]: ../../contributors
