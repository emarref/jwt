<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "jku" (JWK Set URL) Header Parameter
 *
 * The "jku" (JWK Set URL) Header Parameter is a URI [RFC3986] that refers to a resource for a set of JSON-encoded
 * public keys, one of which corresponds to the key used to digitally sign the JWS.  The keys MUST be encoded as a JSON
 * Web Key Set (JWK Set) [JWK].  The protocol used to acquire the resource MUST provide integrity protection; an HTTP
 * GET request to retrieve the JWK Set MUST use TLS [RFC2818, RFC5246]; the identity of the server MUST be validated, as
 * per Section 6 of RFC 6125 [RFC6125].  Also, see Section 8 on TLS requirements.  Use of this Header Parameter is
 * OPTIONAL.
 */
class JwkSetUrl extends AbstractParameter
{
    const NAME = 'jku';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
