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
Attributes can only hold string values, so properties with objects or arrays have to represented as child elements. The
property name is used as the tag name. Array elements each get their own `entry` tag.

For the sake of simplicity, attributes are not supported.

The ToXmlVisitor has to create its own DOMDocument in order to create all these DOMElements. It creates a `root` element
for each object and moves over the child nodes to the appropriate property element later. It also converts non-string
properties to strings, like the ToUrlVisitor.

Deserializer
------------

In order to keep the FromXmlVisitor simple, a DOMElementAccessor was created. This ObjectAccessor lets the Navigator
treat DOMElements as objects. Tag names are mapped to properties, and -- because an element with the same name can
appear more than once -- every property has an array type.

If we try to deserialize a DOMDocument that way, we are left with two types of wrappers... Properties have an array
wrapper, and arrays have an entry wrapper. At the end of each object (which corresponds to a closing tag for an
element with child elements) the FromXmlVisitor has to decide whether to remove the array wrapper or the entry wrapper.

Tracking types is also harder. The easiest way was to tell the DeserializerVisitor that it has to look for a `string[]`
instead of a `string`, and a `PhoneNumber[][]` instead of a `PhoneNumber[]`, etc.
