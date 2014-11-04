<?php

namespace Emarref\Jwt\Claim;

/**
 * "iss" (Issuer) Claim
 *
 * The iss (issuer) claim identifies the principal that issued the JWT. The processing of this claim is generally
 * application specific. The iss value is a case-sensitive string containing a StringOrURI value. Use of this claim is
 * OPTIONAL.
 */
class Issuer extends AbstractClaim
{
    const NAME = 'iss';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 
