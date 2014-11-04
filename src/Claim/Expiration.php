<?php

namespace Emarref\Jwt\Claim;

/**
 * "exp" (Expiration Time) Claim
 *
 * The exp (expiration time) claim identifies the expiration time on or after which the JWT MUST NOT be accepted for
 * processing. The processing of the exp claim requires that the current date/time MUST be before the expiration
 * date/time listed in the exp claim. Implementers MAY provide for some small leeway, usually no more than a few
 * minutes, to account for clock skew. Its value MUST be a number containing a NumericDate value. Use of this claim is
 * OPTIONAL.
 */
class Expiration extends DateValueClaim
{
    const NAME = 'exp';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 
