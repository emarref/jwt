<?php

namespace Emarref\Jwt\Signature;

use Emarref\Jwt\Algorithm\AlgorithmInterface;
use Emarref\Jwt\Encoding\EncoderInterface;
use Emarref\Jwt\HeaderParameter\Algorithm;
use Emarref\Jwt\Token;

class Jws implements SignerInterface
{
    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    public function __construct(AlgorithmInterface $algorithm, EncoderInterface $encoder)
    {
        $this->algorithm = $algorithm;
        $this->encoder   = $encoder;
    }

    /**
     * @param Token $token
     * @param string $signingKey
     * @return string
     */
    public function computeSignature(Token $token, $signingKey)
    {
        $messageToSign = $this->getUnencryptedSignature($token);
        return $this->algorithm->sign($messageToSign, $signingKey);
    }

    /**
     * @param Token $token
     * @return string
     */
    public function getUnencryptedSignature(Token $token)
    {
        $jsonHeader    = $token->getHeader()->getParameters()->jsonSerialize();
        $encodedHeader = $this->encoder->encode($jsonHeader);

        $jsonPayload    = $token->getPayload()->getClaims()->jsonSerialize();
        $encodedPayload = $this->encoder->encode($jsonPayload);

        return sprintf('%s.%s', $encodedHeader, $encodedPayload);
    }

    /**
     * @param Token $token
     * @param string $signingKey
     */
    public function sign(Token $token, $signingKey)
    {
        $token->addHeader(new Algorithm($this->algorithm->getName()));

        $signature = $this->computeSignature($token, $signingKey);

        $token->setSignature($signature);
    }
}
