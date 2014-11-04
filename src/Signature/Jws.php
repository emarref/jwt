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

    public function computeSignature(Token $token)
    {
        $jsonHeader    = $token->getHeader()->getParameters()->jsonSerialize();
        $encodedHeader = $this->encoder->encode($jsonHeader);

        $jsonPayload    = $token->getPayload()->getClaims()->jsonSerialize();
        $encodedPayload = $this->encoder->encode($jsonPayload);

        $rawSignature = sprintf('%s.%s', $encodedHeader, $encodedPayload);
        return $this->algorithm->compute($rawSignature);
    }

    public function sign(Token $token)
    {
        $token->addHeader(new Algorithm($this->algorithm->getName()));

        $signature = $this->computeSignature($token);

        $token->setSignature($signature);
    }
}
