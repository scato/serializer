Xml
===

Implementing XML was very hard.

Encoder/Decoder
---------------

The XmlEncoder and XmlDecoder wrap around `DOMDocument::saveXML()` and `DOMDocument::loadXML()`. That means that the
data tree should be a DOMDocument.

Serializer
----------

A DOMElement has a tag name, attributes and child nodes. This does not map well to objects with classes and properties.
Attributes can only hold string values, so properties with objects or arrays have to be represented as child elements.
The property name is used as the tag name. Array elements each get their own `entry` tag.

For the sake of simplicity, attributes are not supported.

The ToXmlVisitor has to create its own DOMDocument in order to create all these DOMElements. It creates a `root` element
for each object and moves the child nodes over to the appropriate property element later. It also converts non-string
properties to strings, like the ToUrlVisitor.

Navigator/ObjectAccessor
------------------------

In order to keep the FromXmlVisitor simple, a DOMElementAccessor was created. This ObjectAccessor lets the Navigator
treat DOMElements as objects. Tag names are mapped to properties, and -- because an element with the same name can
appear more than once -- every property has an array type.

A special DOMNavigator was added to make another change to the method of traversal. Instead of walking each property as
an array, properties are visited multiple times. For example, if an element has two child elements named `entry`, it
will:
   - call `visitElementStart('entry')`
   - visit the first value
   - call `visitElementEnd('entry')`
   - call `visitElementStart('entry')`
   - visit the second value
   - call `visitElementEnd('entry')`

Deserializer
------------

If we try to deserialize a DOMDocument that way, we still have to collect values in arrays. That way, we are left with
two types of wrappers.

Object properties have an array wrapper, an indexed array with only one element. At the end of each object, the
FromXmlVisitor has to unwrap these indexed arrays, leaving only the associative array.

Arrays have an entry wrapper, an associative array with only one key: `entry`. At the end of each array, the
FromXmlVisitor has to unwrap this array, leaving only the indexed array it contains.
