<?php

namespace Emarref\Jwt\HeaderParameter;

/**
 * "x5c" (X.509 Certificate Chain) Header Parameter
 *
 * The "x5c" (X.509 Certificate Chain) Header Parameter contains the X.509 public key certificate or certificate chain
 * [RFC5280] corresponding to the key used to digitally sign the JWS.  The certificate or certificate chain is
 * represented as a JSON array of certificate value strings.  Each string in the array is a base64 encoded ([RFC4648]
 * Section 4 -- not base64url encoded) DER [ITU.X690.1994] PKIX certificate value.  The certificate containing the
 * public key corresponding to the key used to digitally sign the JWS MUST be the first certificate.  This MAY be
 * followed by additional certificates, with each subsequent certificate being the one used to certify the previous one.
 * The recipient MUST validate the certificate chain according to RFC 5280 [RFC5280] and reject the signature if any
 * validation failure occurs.  Use of this Header Parameter is OPTIONAL.
 *
 * See Appendix B for an example "x5c" value.
 */
class X509CertificateChain extends AbstractParameter
{
    const NAME = 'x5c';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
