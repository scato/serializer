Core
====

The Core namespace contains the basic serialization framework.

Definitions
-----------

When you pass an object into a serializer, the object and all the objects it refers to is called *the object graph*.

When you deserialize a string, you will first get a tree consisting of strings, arrays, `stdClass` objects and/or
`DOMElements`. This, we will call *the data tree*.

Navigator
---------

The [Navigator](Navigation.md) object takes care of the traversal.

Visitor
-------

[Visitors](Navigation.md) are used to transform object graphs into data trees and vice versa.

Encoder/Decoder
---------------

These are the objects that turn data trees into [JSON](Json.md), [XML](Xml.md) or [URL encoded](Url.md) strings and
vice versa. They are basically wrappers for built-in JSON, XML and URL functions.

Serializer
----------

A Serializer uses a Navigator to guide a Visitor through an object graph. The Visitor constructs a data tree that the
Serializer then runs through an Encoder, which produces the final string.

Deserializer
------------

A Deserializer more or less does the same thing as a Serializer, but in reverse. First, it runs the input string
through a Decoder, producing a data tree. Then, it uses a Navigator to guide a Visitor through that tree. The Visitor
constructs the final object graph.

To construct the object graph, the Visitor is told which type is associated with the root of the data tree. It is
then up to the Visitor to figure out which type to associate with each of the underlying nodes.

SerializerFacade
----------------

There is a facade that ties everything together. It has a `serialize()` and `deserialize()` method that take a format
as a parameter. It uses a set of Serializer and Deserializer factories to instantiate de appropriate object, which does
the real work.

Type
----

Finally, there is a value object that represents the types used in `@var` tags.
