<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Exception;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Serialization;
use Emarref\Jwt\Signature;
use Emarref\Jwt\Verification;

class Jwt
{
    /**
     * @var Encoding\EncoderInterface
     */
    private $encoder;

    public function __construct()
    {
        $this->encoder = new Encoding\Base64();
    }

    /**
     * @param string $jwt
     * @return Token
     */
    public function deserialize($jwt)
    {
        $serialization = new Serialization\Compact($this->encoder);

        return $serialization->deserialize($jwt);
    }

    /**
     * @param Token                             $token
     * @param Algorithm\AlgorithmInterface|null $algorithm
     * @return string
     */
    public function serialize(Token $token, Algorithm\AlgorithmInterface $algorithm = null)
    {
        $this->sign($token, $algorithm);

        return (new Serialization\Compact($this->encoder))->serialize($token);
    }

    /**
     * @param Token                        $token
     * @param Algorithm\AlgorithmInterface $algorithm
     */
    public function sign(Token $token, Algorithm\AlgorithmInterface $algorithm = null)
    {
        if (null === $algorithm) {
            $algorithm = new Algorithm\None();
        }

        $signer = new Signature\Jws($algorithm, $this->encoder);
        $signer->sign($token);
    }

    /**
     * @param Verification\Context $context
     * @return Verification\VerifierInterface[]
     */
    protected function getVerifiers(Verification\Context $context)
    {
        return [
            new Verification\AlgorithmVerifier($context->getAlgorithm(), $this->encoder),
            new Verification\AudienceVerifier($context->getAudience()),
            new Verification\ExpirationVerifier(),
            new Verification\IssuerVerifier($context->getIssuer()),
        ];
    }

    /**
     * @param Token                $token
     * @param Verification\Context $context
     * @return bool
     */
    public function verify(Token $token, Verification\Context $context)
    {
        if (!$context->getAlgorithm()) {
            $context->setAlgorithm(new Algorithm\None());
        }

        foreach ($this->getVerifiers($context) as $verifier) {
            $verifier->verify($token);
        }

        return true;
    }
}
