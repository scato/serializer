Json
====

Implementing JSON was pretty easy.

Encoder/Decoder
---------------

The JsonEncoder and JsonDecoder wrap around `json_encode()` and `json_decode()`.

Serializer
----------

The SerializerVisitor converts objects into arrays, but JSON supports objects. The ToJsonVisitor converts these arrays
back into objects of class `stdClass`.

Deserializer
------------

For deserialization, the DeserializerVisitor form the Common namespace does the trick. JSON already contains the
right objects, arrays and values because it follows an object oriented paradigm, just like PHP.
