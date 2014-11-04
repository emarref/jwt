<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "cty" (Content Type) Header Parameter
 *
 * The "cty" (content type) Header Parameter is used by JWS applications to declare the MIME Media Type
 * [IANA.MediaTypes] of the secured content (the payload).  This is intended for use by the application when more than
 * one kind of object could be present in the JWS payload; the application can use this value to disambiguate among the
 * different kinds of objects that might be present.  It will typically not be used by applications when the kind of
 * object is already known. This parameter is ignored by JWS implementations; any processing of this parameter is
 * performed by the JWS application.  Use of this Header Parameter is OPTIONAL.
 *
 * Per RFC 2045 [RFC2045], all media type values, subtype values, and parameter names are case-insensitive.  However,
 * parameter values are case-sensitive unless otherwise specified for the specific parameter.
 *
 * To keep messages compact in common situations, it is RECOMMENDED that producers omit an "application/" prefix of a
 * media type value in a "cty" Header Parameter when no other '/' appears in the media type value.  A recipient using
 * the media type value MUST treat it as if "application/" were prepended to any "cty" value not containing a '/'.  For
 * instance, a "cty" value of "example" SHOULD be used to represent the "application/example" media type; whereas, the
 * media type "application/example;part="1/2"" cannot be shortened to "example;part="1/2"".
 */
class ContentType extends AbstractParameter
{
    const NAME = 'cty';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
