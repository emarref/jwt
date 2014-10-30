<?php

namespace Emarref\Jwt\Token\Payload\Claim;

/**
 * "iss" (Issuer) Claim
 *
 * The iss (issuer) claim identifies the principal that issued the JWT. The processing of this claim is generally
 * application specific. The iss value is a case-sensitive string containing a StringOrURI value. Use of this claim is
 * OPTIONAL.
 */
class IssuerClaim extends AbstractClaim
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
