Data
====

I realized that building a serializer this way, also gave me a sort of data mapper -- almost for free!

Encoder/Decoder
---------------

There is no Encoder or Decoder. Instead, there is a Mapper which behaves just like a Deserializer, but without any
encoding.

Mapper
------

The Mapper uses the DeserializeVisitor. It maps arrays to objects, which is exactly what we need. On top of that, if
you pass 'mixed' as the type, it maps objects to arrays.
