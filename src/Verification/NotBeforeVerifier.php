<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class NotBeforeVerifier implements VerifierInterface
{
    public function verify(Token $token)
    {
        /** @var Claim\NotBefore $notBeforeClaim */
        $notBeforeClaim = $token->getPayload()->findClaimByName(Claim\NotBefore::NAME);

        if (null === $notBeforeClaim) {
            return null;
        }

        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if ($now->getTimestamp() < $notBeforeClaim->getValue()) {
            $notBefore = new \DateTime();
            $notBefore->setTimestamp($notBeforeClaim->getValue());
            throw new VerificationException(sprintf('Token must not be processed before "%s"', $notBefore->format('r')));
        }
    }
}
