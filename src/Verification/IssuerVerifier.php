<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class IssuerVerifier implements VerifierInterface
{
    /**
     * @var string
     */
    private $issuer;

    /**
     * @param string $issuer
     */
    public function __construct($issuer = null)
    {
        if (null !== $issuer && !is_string($issuer)) {
            throw new \InvalidArgumentException('Cannot verify invalid issuer value.');
        }

        $this->issuer = $issuer;
    }

    /**
     * @param Token $token
     * @throws VerificationException
     */
    public function verify(Token $token)
    {
        /** @var Claim\Issuer $issuerClaim */
        $issuerClaim = $token->getPayload()->findClaimByName(Claim\Issuer::NAME);

        $issuer = (null === $issuerClaim) ? null : $issuerClaim->getValue();

        if ($this->issuer !== $issuer) {
            throw new VerificationException('Issuer is invalid.', VerificationException::CODE_INVALID_ISSUER);
        }
    }
}
