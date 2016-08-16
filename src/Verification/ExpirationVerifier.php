<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Exception\ExpiredException;
use Emarref\Jwt\Token;

class ExpirationVerifier implements VerifierInterface
{
    /**
     * @param Claim\Expiration $expirationClaim
     * @throws \InvalidArgumentException
     * @return \DateTime
     */
    private function getDateTimeFromClaim(Claim\Expiration $expirationClaim)
    {
        if (!is_long($expirationClaim->getValue())) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid expiration timestamp "%s"',
                $expirationClaim->getValue()
            ));
        }

        $expiration = new \DateTime();
        $expiration->setTimestamp($expirationClaim->getValue());
        return $expiration;
    }

    public function verify(Token $token)
    {
        /** @var Claim\Expiration $expirationClaim */
        $expirationClaim = $token->getPayload()->findClaimByName(Claim\Expiration::NAME);

        if (null === $expirationClaim) {
            return null;
        }

        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if ($now->getTimestamp() > $expirationClaim->getValue()) {
            $expiration = $this->getDateTimeFromClaim($expirationClaim);
            throw new ExpiredException($expiration);
        }
    }
}
