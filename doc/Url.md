Url
===

Implementing URL encoding was a bit tricky.

Encoder/Decoder
---------------

The UrlEncoder and UrlDecoder wrap around `http_build_query()` and `parse_str()`.

Serializer
----------

URL encoded strings can only contain string values, so the ToUrlVisitor has to convert non-string values to strings.

Deserializer
------------

For this same reason, the FromUrlVisitor has to convert these strings back to the appropriate values. To do this, URL
encoding needs more type information than JSON.
