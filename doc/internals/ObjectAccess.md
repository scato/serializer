ObjectAccess
============

The ObjectAccess namespace contains classes that read and create objects.

ObjectAccessor/ObjectFactory
----------------------------

There ObjectAccess namespace contains two simple implementations for reading properties and creating objects. They work with
the built-in mechanisms of PHP. Reading a property is done through `$object->{$name}`. Creating an object is done
through `new $class()`.

ReflectionTypeProvider
----------------------

There is one TypeProvider in this namespace which uses reflection and the phpdocumentor/reflection-docblock component
to read `@var` tags.
