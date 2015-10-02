Navigation
==========

The Navigation namespace contains classes that handle traversal and transformation of the object graphs and data trees.

Navigator
---------

This object can traverse both object graphs and data trees.

SerializeVisitor
----------------

This visitor uses a result stack to collect results. While traversing an object graph, it rebuilds that graph, replacing
objects with arrays.

It also supplies a template method to recreate an object from a value or an array it constructed.

DeserializeVisitor
------------------

This visitor extends the SerializeVisitor. It uses a type stack to track the type corresponding to each part of the
data tree. It supplies helper method for pushing the type for a certain property on the stack, as well as the type
of an element in an array.

It overrides the template method for creating objects, delegating to an [ObjectFactory](ObjectAccess.md).

ObjectAccessor
--------------

The [ObjectAccessor](ObjectAccess.md) object knows how to find the names of the properties of an object, as well as
retrieve values for those properties.

To traverse the properties of an object, the Navigator is assisted by an ObjectAccessor.

TypeProvider
------------

This is an object that the DeserializeVisitor uses to find out which type a property has.

SerializationConverter
----------------------

SerializationConverters are a way for consumers of this library to hook into the serialization process. A
ConversionNavigatorDecorator is used to wrap around a Navigator and pass the value through a SerializationConverter
before handing it to the Navigator.

You can add more SerializationConverters by wrapping around the Navigator multiple times.

DeserializationFilter
---------------------

DeserializationFilters are a way for consumers of this library to hook into the deserialization process. A
FilteringObjectFactoryDecorator is used to wrap around an ObjectFactory and allow the DeserializationFilter to either
handle object creation by itself, or delegate it to the ObjectFactory it wraps.

You can add more DeserializationFilters by wrapping around the ObjectFactory multiple times.
