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
        $serialization = new Serialization\Compact(
            $this->encoder,
            new HeaderParameter\Factory(),
            new Claim\Factory()
        );

        return $serialization->deserialize($jwt);
    }

    /**
     * @param Token                             $token
     * @param Algorithm\AlgorithmInterface|null $algorithm
     * @param string                            $signingKey
     * @return string
     */
    public function serialize(Token $token, Algorithm\AlgorithmInterface $algorithm = null, $signingKey = null)
    {
        $this->sign($token, $algorithm, $signingKey);

        $serialization = new Serialization\Compact(
            $this->encoder,
            new HeaderParameter\Factory(),
            new Claim\Factory()
        );

        return $serialization->serialize($token);
    }

    /**
     * @param Token                        $token
     * @param Algorithm\AlgorithmInterface $algorithm
     * @param string                       $signingKey
     */
    public function sign(Token $token, Algorithm\AlgorithmInterface $algorithm = null, $signingKey = null)
    {
        if (null === $algorithm) {
            $algorithm = new Algorithm\None();
        }

        $signer = new Signature\Jws($algorithm, $this->encoder);
        $signer->sign($token, $signingKey);
    }

    /**
     * @param Verification\Context $context
     * @return Verification\VerifierInterface[]
     */
    protected function getVerifiers(Verification\Context $context)
    {
        return [
            new Verification\AlgorithmVerifier($context->getAlgorithm(),$context->getVerificationKey(), $this->encoder),
            new Verification\AudienceVerifier($context->getAudience()),
            new Verification\ExpirationVerifier(),
            new Verification\IssuerVerifier($context->getIssuer()),
            new Verification\NotBeforeVerifier(),
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

        if (!$context->getVerificationKey()) {
            $context->setVerificationKey('');
        }

        $signer = new Signature\Jws($context->getAlgorithm(), $this->encoder);

        foreach ($this->getVerifiers($context) as $verifier) {
            $verifier->verify($token);
        }

        return true;
    }
}
