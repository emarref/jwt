<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "alg" (Algorithm) Header Parameter
 *
 * The "alg" (algorithm) Header Parameter identifies the cryptographic algorithm used to secure the JWS. The JWS
 * Signature value is not valid if the "alg" value does not represent a supported algorithm, or if there is not a key
 * for use with that algorithm associated with the party that digitally signed or MACed the content. "alg" values should
 * either be registered in the IANA JSON Web Signature and Encryption Algorithms registry defined in [JWA] or be a value
 * that contains a Collision-Resistant Name.  The "alg" value is a case-sensitive string containing a StringOrURI value.
 * This Header Parameter MUST be present and MUST be understood and processed by implementations.
 *
 * A list of defined "alg" values for this use can be found in the IANA JSON Web Signature and Encryption Algorithms
 * registry defined in [JWA]; the initial contents of this registry are the values defined in Section 3.1 of the JSON
 * Web Algorithms (JWA) [JWA] specification.
 */
class Algorithm extends AbstractParameter
{
    const NAME = 'alg';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
