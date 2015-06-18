Common
======

The Common namespace contains basic implementations to help with further implementations of each format.

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

TypeProvider
------------

This is an object that the DeserializerVisitor uses to find out which type a property has.

There is one implementation in this namespace which uses reflection and the phpdocumentor/reflection-docblock component
to read `@var` tags.

ObjectAccessor/ObjectFactory
----------------------------

There Common namespace contains two simple implementations for reading properties and creating objects. They work with
the built-in mechanisms of PHP. Reading a property is done through `$object->{$name}`. Creating an object is done
through `new $class()`.