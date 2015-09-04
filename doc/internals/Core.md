Core
====

The Core namespace contains the basic serialization framework.

Definition: Object Graph
------------------------

When you pass an object into a serializer, the object and all the objects it refers to is called *the object graph*.

Definition: Data Tree
---------------------

When you deserialize a string, you will first get a tree consisting of strings, arrays, stdClass objects and/or
DOMElements. This, we will call *the data tree*.

Encoder/Decoder
---------------

These are the objects that turn data trees into a strings and vice versa. They are basically wrappers for JSON, XML and
URL functions.

Navigator
---------

This object takes care of the traversal.

Visitor
-------

Visitors are used to transform object graphs into data trees and vice versa.

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
then up to the Visitor to figure out which type to associate with each of the other nodes.

Type
----

Finally, there is a value object that represents the types used in `@var` tags.
