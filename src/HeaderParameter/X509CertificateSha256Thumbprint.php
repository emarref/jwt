<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "x5t#S256" (X.509 Certificate SHA-256 Thumbprint) Header Parameter
 *
 * The "x5t#S256" (X.509 Certificate SHA-256 Thumbprint) Header Parameter is a base64url encoded SHA-256 thumbprint
 * (a.k.a. digest) of the DER encoding of the X.509 certificate [RFC5280] corresponding to the key used to digitally
 * sign the JWS.  Note that certificate thumbprints are also sometimes known as certificate fingerprints. Use of this
 * Header Parameter is OPTIONAL.
 */
class X509CertificateSha256Thumbprint extends AbstractParameter
{
    const NAME = 'x5t#S256';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
