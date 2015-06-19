Data
====

I realized that building a serializer this way, also gave me a sort of data mapper -- almost for free!

Encoder/Decoder
---------------

There is no Encoder or Decoder. Instead, there is a Mapper which behaves just like a Deserializer, but without any
encoding.

Mapper
------

The Mapper uses the FromUrlVisitor, which happens to traverse objects as well as arrays. It is already smart about
creating objects, which it only does for class types.

In order to map objects back to arrays, I had to write an ArrayTypeProviderDecorator, which is used to decorate the
ReflectionTypeProvider. If it is asked for the type of a property on an array type (like `string[]`), it returns the
appropriate element type (in this case: `string`).
