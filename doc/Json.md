Json
====

Implementing JSON was pretty easy.

Encoder/Decoder
---------------

The JsonEncoder and JsonDecoder wrap around `json_encode()` and `json_decode()`. The JsonDecoder will not produce
objects of stdClass, but associative arrays instead.

Serializer
----------

The SerializerVisitor converts objects into arrays, which the encoder automatically converts back to objects.

Deserializer
------------

For deserialization, the DeserializerVisitor also does the trick. JSON already contains the right arrays and values
because it follows an object oriented paradigm, just like PHP.
