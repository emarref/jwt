<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "x5t" (X.509 Certificate SHA-1 Thumbprint) Header Parameter
 *
 * The "x5t" (X.509 Certificate SHA-1 Thumbprint) Header Parameter is a base64url encoded SHA-1 thumbprint (a.k.a.
 * digest) of the DER encoding of the X.509 certificate [RFC5280] corresponding to the key used to digitally sign the
 * JWS.  Note that certificate thumbprints are also sometimes known as certificate fingerprints.  Use of this Header
 * Parameter is OPTIONAL.
 */
class X509CertificateSha1Thumbprint extends AbstractParameter
{
    const NAME = 'x5t';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
