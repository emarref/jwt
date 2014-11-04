<?php

namespace Emarref\Jwt\Claim;

/**
 * "nbf" (Not Before) Claim
 *
 * The nbf (not before) claim identifies the time before which the JWT MUST NOT be accepted for processing. The
 * processing of the nbf claim requires that the current date/time MUST be after or equal to the not-before date/time
 * listed in the nbf claim. Implementers MAY provide for some small leeway, usually no more than a few minutes, to
 * account for clock skew. Its value MUST be a number containing a NumericDate value. Use of this claim is OPTIONAL.
 */
class NotBefore extends DateValueClaim
{
    const NAME = 'nbf';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 
