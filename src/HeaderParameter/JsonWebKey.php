<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "jwk" (JSON Web Key) Header Parameter
 *
 * The "jwk" (JSON Web Key) Header Parameter is the public key that corresponds to the key used to digitally sign the
 * JWS.  This key is represented as a JSON Web Key [JWK].  Use of this Header Parameter is OPTIONAL.
 */
class JsonWebKey extends AbstractParameter
{
    const NAME = 'jwk';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
