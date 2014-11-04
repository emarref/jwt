<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class ExpirationVerifier implements VerifierInterface
{
    public function verify(Token $token)
    {
        /** @var Claim\Expiration $expirationClaim */
        $expirationClaim = $token->getPayload()->findClaimByName(Claim\Expiration::NAME);

        if (null === $expirationClaim) {
            return null;
        }

        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if ($now->getTimestamp() > $expirationClaim->getValue()) {
            $expiration = new \DateTime();
            $expiration->setTimestamp($expirationClaim->getValue());
            throw new VerificationException(sprintf('Token expired at "%s"', $expiration->format('r')));
        }
    }
}
