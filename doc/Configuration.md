Configuration
=============

There is no way to configure the serializer yet. That means that you can only use objects with public properties and
zero constructor arguments. Also, polymorphism is not supported.

Below is a list of JMS Serializer Annotations, and the way they would have to be implemented in this serializer.

ExclusionPolicy/Exclude/Expose
------------------------------

An ObjectAccessor decorator could filter names according to the exclusion policy. The result for getNames() would pass
through either a whitelist or a blacklist.

SerializedName
--------------

An ObjectAccessor decorator could map names and use the same mapping to retrieve the right value. The result for
getNames() should be mapped. The name for getValue() should be mapped back.

An ObjectFactory decorator could apply the same mapping. The keys for the array passed to createObject would have to be
mapped back to property names, just like the name for getValue().

Since/Until
-----------

An ObjectAccessor decorator could filter names according to the current version. This version would have to be a
constructor argument. In JMS Seralizer, it's part of the Context, but so is format. In this serializer, format is
determined when the serializer is constructed. Version doesn't have to be any different.

Groups
------

An ObjectAccessor decorator could filter names according to group. Again, these groups are part of the Context in JMS
Serializer. They can be constructor arguments in this serializer.

MaxDepth
--------

For this option, we would need to change the Navigator. The accept() method would have to get an extra depth parameter.
It could then use a special Visitor that tracks both the current depth and each of the maximum depths imposed, so the
Navigator can ask it whether the maximum depth has been reached yet along each step of the way.

What would it have to do, though? When it reaches this maximum? Tell the visitor the value is null instead? Or just not
descend into objects and arrays?

AccessType
----------

An ObjectAccessorProvider could check each class for an AccessType option, and return the appropriate ObjectAccessor.
A special ObjectAccessor could use this ObjectAccessorProvider to choose a strategy on a class by class basis.

Accessor
--------

An ObjectAccessor decorator could check a property for this option for each call to getValue(). An ObjectFactory
decorator could do the same for each call to createObject().

AccessorOrder
-------------

An ObjectAccessor decorator could sort the names depending on this option.

VirtualProperty
---------------

An ObjectAccessor decorator could add all virtual properties to the name, and offer a way to retrieve the value as well.

Inline
------

The Navigator would have to be extended to have an inline mode. In inline mode, it can skip visitPropertyStart() and
visitPropertyEnd(), as well as the visitObjectStart() and visitObjectEnd() in the first level below. This can cause
the Visitor to visit a property with the same name twice. The ToXmlVisitor doesn't mind, and XML is the only encoding
that supports this anyway. JSON and URL will just silently overwrite the first property.

ReadOnly
--------

An ObjectFactory decorator could remove values for read only properties from the array passed to createObject().

PreSerialize/PostSerialize
--------------------------

The Navigator would have to be extended to add these hooks.

PostDeserialize
---------------

An ObjectFactory decorator could check for this hook, and call it for every object it creates.

HandlerCallback
---------------

The Navigator would have to handle the callbacks. The callback would then replace the normal accept functionality. The
Navigator would also have to know what the current type is, so the TypedVisitor should expose that.

Discriminator
-------------

An ObjectFactory decorator could change the type of a call to createObject to a subclass of that type, depending on the
values in the array.

An ObjectAccessor could maybe even add a special tag name property to that array, so that could be used for
discrimination as well. (Although this would only work for XML and only on the root node.)

Type
----

A TypeProvider could use these options instead of `@var` tags. 

A ConvertorProvider could use these same options to provide conversions for DateTime and ArrayCollection. The Navigator
could be decorated to apply these conversions before letting the real Navigator accept them.

Xml
---

XmlRoot
XmlAttribute
XmlValue
XmlList
XmlMap
XmlKeyValuePairs
XmlAttributeMap
XmlElement
XmlNamespace

A new Navigator
---------------

We could create an entire whitelist/blacklist system, and hook that to the ObjectAccessors and ObjectFactories using two
decorators. The same goes for conversions and readonly properties, or handler callbacks in general.

That is, property-based conversions work well with the ObjectAccessor/ObjectFactory layer, but we need another system to
handle type-based conversions. Maybe it's better to combine the property-based conversions with this one. Serialization
conversions should be handled by the Navigator, deserialization conversions by the Visitors.
