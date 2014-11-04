<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "kid" (Key ID) Header Parameter
 *
 * The "kid" (key ID) Header Parameter is a hint indicating which key was used to secure the JWS.  This parameter allows
 * originators to explicitly signal a change of key to recipients.  The structure of the "kid" value is unspecified. Its
 * value MUST be a case-sensitive string.  Use of this Header Parameter is OPTIONAL.
 *
 * When used with a JWK, the "kid" value is used to match a JWK "kid" parameter value.
 */
class KeyId extends AbstractParameter
{
    const NAME = 'kid';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
