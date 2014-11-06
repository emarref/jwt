<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Signature;
use Emarref\Jwt\Token;

class AlgorithmVerifier implements VerifierInterface
{
    /**
     * @var HeaderParameter\Algorithm
     */
    private $algorithm;

    /**
     * @var string
     */
    private $verificationKey;

    /**
     * @var Encoding\EncoderInterface
     */
    private $encoder;

    /**
     * @param Algorithm\AlgorithmInterface $algorithm
     * @param string                       $verificationKey
     * @param Encoding\EncoderInterface    $encoder
     */
    public function __construct(
        Algorithm\AlgorithmInterface $algorithm,
        $verificationKey,
        Encoding\EncoderInterface $encoder)
    {
        $this->algorithm = $algorithm;
        $this->verificationKey = $verificationKey;
        $this->encoder   = $encoder;
    }

    /**
     * @param Token $token
     * @throws VerificationException
     */
    public function verify(Token $token)
    {
        /** @var HeaderParameter\Algorithm $algorithmParameter */
        $algorithmParameter = $token->getHeader()->findParameterByName(HeaderParameter\Algorithm::NAME);

        if (null === $algorithmParameter) {
            throw new \RuntimeException('Algorithm parameter not found in token header.');
        }

        if ($algorithmParameter->getValue() !== $this->algorithm->getName()) {
            throw new \RuntimeException(sprintf(
                'Cannot use "%s" algorithm to decrypt token encrypted with algorithm "%s".',
                $this->algorithm->getName(),
                $algorithmParameter->getValue()
            ));
        }

        $jsonHeader    = $token->getHeader()->getParameters()->jsonSerialize();
        $encodedHeader = $this->encoder->encode($jsonHeader);

        $jsonPayload    = $token->getPayload()->getClaims()->jsonSerialize();
        $encodedPayload = $this->encoder->encode($jsonPayload);

        $message = sprintf("%s.%s", $encodedHeader, $encodedPayload);

        $signatureValid = $this->algorithm->check($message, $token->getSignature(), $this->verificationKey);

        if (!$signatureValid) {
            throw new VerificationException('Token signature is invalid.');
        }
    }
}
