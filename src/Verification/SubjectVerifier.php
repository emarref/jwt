<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class SubjectVerifier implements VerifierInterface
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @param string $subject
     */
    public function __construct($subject = null)
    {
        if (null !== $subject && !is_string($subject)) {
            throw new \InvalidArgumentException('Cannot verify invalid subject value.');
        }

        $this->subject = $subject;
    }

    /**
     * @param Token $token
     * @throws VerificationException
     */
    public function verify(Token $token)
    {
        /** @var Claim\Subject $subjectClaim */
        $subjectClaim = $token->getPayload()->findClaimByName(Claim\Subject::NAME);

        $subject = (null === $subjectClaim) ? null : $subjectClaim->getValue();

        if ($this->subject !== $subject) {
            throw new VerificationException('Subject is invalid.');
        }
    }
}
