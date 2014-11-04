<?php

namespace Emarref\Jwt\Claim;

/**
 * "iat" (Issued At) Claim
 *
 * The iat (issued at) claim identifies the time at which the JWT was issued. This claim can be used to determine the
 * age of the JWT. Its value MUST be a number containing a NumericDate value. Use of this claim is OPTIONAL.
 */
class IssuedAt extends DateValueClaim
{
    const NAME = 'iat';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 
