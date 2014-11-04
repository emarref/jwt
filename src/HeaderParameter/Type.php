<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "typ" (Type) Header Parameter
 *
 * The "typ" (type) Header Parameter is used by JWS applications to declare the MIME Media Type [IANA.MediaTypes] of
 * this complete JWS object.  This is intended for use by the application when more than one kind of object could be
 * present in an application data structure that can contain a JWS object; the application can use this value to
 * disambiguate among the different kinds of objects that might be present.  It will typically not be used by
 * applications when the kind of object is already known.  This parameter is ignored by JWS implementations; any
 * processing of this parameter is performed by the JWS application.  Use of this Header Parameter is OPTIONAL.
 *
 * Per RFC 2045 [RFC2045], all media type values, subtype values, and parameter names are case-insensitive.  However,
 * parameter values are case-sensitive unless otherwise specified for the specific parameter.
 *
 * To keep messages compact in common situations, it is RECOMMENDED that producers omit an "application/" prefix of a
 * media type value in a "typ" Header Parameter when no other '/' appears in the media type value.  A recipient using
 * the media type value MUST treat it as if "application/" were prepended to any "typ" value not containing a '/'.  For
 * instance, a "typ" value of "example" SHOULD be used to represent the "application/example" media type; whereas, the
 * media type "application/example;part="1/2"" cannot be shortened to "example;part="1/2"".
 *
 * The "typ" value "JOSE" can be used by applications to indicate that this object is a JWS or JWE using the JWS Compact
 * Serialization or the JWE Compact Serialization.  The "typ" value "JOSE+JSON" can be used by applications to indicate
 * that this object is a JWS or JWE using the JWS JSON Serialization or the JWE JSON Serialization. Other type values
 * can also be used by applications.
 */
class Type extends AbstractParameter
{
    const NAME = 'typ';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
