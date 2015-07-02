# Serializer

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Coz... how hard can it be?

The answer is: pretty hard!

## Encoding
The first part of the problem is the encoding: converting a JSON/XML/URL encoded string to a data tree and back. This is the
easy part. We have libraries and extensions to do that for us.

## Transformation
The second -- and hardest -- part of serialization is transforming a PHP object graph into a data tree and back.

First, we have to figure out how to access PHP objects during serialization, and how to create them during
deserialization.

Second, we have to come up with a strategy to traverse the object graph or data tree. The answer is of course: the
Visitor Pattern. But then we need a Navigator to guide that visitor through the graph or tree.

Third, we have to figure out how to access objects in the data tree (stdClass for JSON, DOMElement for XML) during
deserialization, and how to create them during serialization.

Last, but not least, during deserialization, we need to know what type each part of the data tree belongs to. If we know
what type the root should be, we should be able to figure out which type each property and element belongs to.

## Configuration
And then there are all those nasty little details: DateTime to string conversion, property white/black listing, mapping
property names, XML root tag names, XML attributes...

And you want to be able to do that with either annotations or configuration files in any possible format.

Following the *less is more* philosophy, I decided not to implement any configuration. The structure is set up pretty
modular, so it shouldn't be hard to add. It's just a lot of work.

## The Serializer
Look at the `doc/` folder to find out what the serializer looks like.

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
