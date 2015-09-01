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

It also supplies a template method to recreate an object from the array that it constructed.

DeserializeVisitor
------------------

This visitor extends the SerializerVisitor. It uses a type stack to track the type corresponding to each part of the
data tree. It supplies helper method for pushing the type for a certain property on the stack, as well as the type
of an element in an array.

It overrides the template method for creating objects, delegating to an Object Factory.

ObjectAccessor
--------------

This object knows how to find the names of the properties of an object, as well as retrieve values for those properties.

To traverse the properties of an object, the Navigator is assisted by an ObjectAccessor.

TypeProvider
------------

This is an object that the DeserializerVisitor uses to find out which type a property has.
